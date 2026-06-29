<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCommonFields;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class Company extends Model
{
    use HasCommonFields;
    protected $fillable = ['name', 'slug', 'logo', 'description', 'address', 'website', 'active', 'ord'];

    protected $casts = [
        'extra_attributes' => 'array',
    ];

    public function get_field(string $key, $default = null)
    {
        $value = data_get($this->extra_attributes ?? [], $key);
        if (is_null($value)) {
            $value = $this->getAttribute($key);
        }

        return $value ?? $default;
    }

    protected static function booted(): void
    {
        static::saved(function (Company $company) {
            if (!config('services.crm_sync.enabled')) {
                return;
            }

            if (!Schema::connection('sub_mysql')->hasTable('companies')) {
                return;
            }

            $columns = Schema::connection('sub_mysql')->getColumnListing('companies');
            $columns = array_diff($columns, ['id']);

            $data = [];
            foreach ($columns as $col) {
                if ($col === 'created_at') {
                    $data[$col] = $company->created_at ?? now();
                } elseif ($col === 'updated_at') {
                    $data[$col] = now();
                } else {
                    $data[$col] = $company->{$col} ?? null;
                }
            }
            $data['id'] = $company->id;

            try {
                DB::connection('sub_mysql')
                    ->table('companies')
                    ->upsert([$data], ['id'], $columns);
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('SyncCompanyToCrm failed: ' . $e->getMessage());
            }
        });
    }
}
