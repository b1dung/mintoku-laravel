<?php

namespace App\Console\Commands;

use App\Models\Job;
use App\Models\Company;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SyncJobsToCrm extends Command
{
    protected $signature = 'sync:jobs-to-crm
                            {--chunk=100 : Number of records per chunk}';

    protected $description = 'Sync all companies & jobs from main DB to CRM sub DB';

    private const TARGET_JOBS = 'job_postings';
    private const TARGET_COMPANIES = 'companies';

    public function handle(): int
    {
        if (!config('services.crm_sync.enabled')) {
            $this->warn('CRM sync is disabled. Set CRM_SYNC_ENABLED=true to run this command.');
            return Command::SUCCESS;
        }

        $targetConn = DB::connection('sub_mysql');

        // Check tables
        if (!Schema::connection('sub_mysql')->hasTable(self::TARGET_JOBS)) {
            $this->error("Table '" . self::TARGET_JOBS . "' does not exist in CRM database.");
            return Command::FAILURE;
        }
        if (!Schema::connection('sub_mysql')->hasTable(self::TARGET_COMPANIES)) {
            $this->error("Table '" . self::TARGET_COMPANIES . "' does not exist in CRM database.");
            return Command::FAILURE;
        }

        // --- Step 1: Sync companies ---
        $this->syncTable(
            $targetConn,
            self::TARGET_COMPANIES,
            Company::query(),
            function ($company) {
                return [
                    'created_at' => $company->created_at ?? now(),
                    'updated_at' => now(),
                ];
            }
        );

        // --- Step 2: Sync jobs ---
        $this->syncTable(
            $targetConn,
            self::TARGET_JOBS,
            Job::query(),
            function ($job) {
                return [
                    'created_at' => $job->created_at ?? now(),
                    'updated_at' => now(),
                    'extra_attributes' => json_encode($job->extra_attributes ?? []),
                ];
            }
        );

        return Command::SUCCESS;
    }

    private function syncTable($targetConn, string $table, $query, callable $extraFieldResolver): void
    {
        $fillColumns = Schema::connection('sub_mysql')->getColumnListing($table);
        $fillColumns = array_diff($fillColumns, ['id']);

        $total = $query->count();
        $chunk = (int) $this->option('chunk');

        $this->info("Syncing {$total} records to {$table} (chunk size: {$chunk})...");
        $bar = $this->output->createProgressBar($total);
        $bar->start();

        $processed = 0;

        $query->orderBy('id')->chunk($chunk, function ($records) use ($targetConn, $table, $fillColumns, $extraFieldResolver, &$processed, $bar) {
            $upsertData = [];

            foreach ($records as $record) {
                $row = [];
                foreach ($fillColumns as $col) {
                    if ($col === 'created_at') {
                        $row[$col] = $record->created_at ?? now();
                    } elseif ($col === 'updated_at') {
                        $row[$col] = now();
                    } elseif ($col === 'extra_attributes') {
                        $row[$col] = json_encode($record->extra_attributes ?? []);
                    } else {
                        $row[$col] = $record->{$col} ?? null;
                    }
                }
                $row['id'] = $record->id;
                $upsertData[] = $row;
            }

            if (!empty($upsertData)) {
                $targetConn->table($table)->upsert($upsertData, ['id'], $fillColumns);
            }

            $processed += count($upsertData);
            $bar->advance(count($upsertData));
        });

        $bar->finish();
        $this->newLine();
        $this->info("Done! {$processed} records synced to {$table}.");
    }
}
