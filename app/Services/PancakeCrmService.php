<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PancakeCrmService
{
    public function createLead(array $data): array
    {
        $workspaceId = config('services.pancake_crm.workspace_id');
        $tableName   = config('services.pancake_crm.table_name');
        $apiKey      = config('services.pancake_crm.api_key');
        $ref         = config('services.pancake_crm.ref', 'mintoku.vn');

        $url = "https://crm.pancake.vn/api/workspaces/{$workspaceId}/{$tableName}/records";

        $payload = [
            'record' => [
                'name'            => $data['full_name'],
                'phone_number'    => $data['phone'],
                'email'           => $data['email'],
                'ref'             => $ref,
                'notes__remarks'  => $this->buildNote($data),
            ],
        ];

        $response = Http::timeout(15)
            ->acceptJson()
            ->post($url . '?api_key=' . $apiKey, $payload);

        if (! $response->successful()) {
            Log::error('Pancake CRM API Error', [
                'status'   => $response->status(),
                'response' => $response->body(),
                'payload'  => $payload,
            ]);

            return [
                'success' => false,
                'status'  => $response->status(),
                'data'    => $response->json(),
            ];
        }

        return [
            'success' => true,
            'status'  => $response->status(),
            'data'    => $response->json(),
        ];
    }

    private function buildNote(array $data): string
    {
        $subjectType = match ($data['subject_type'] ?? null) {
            'individual' => 'Cá nhân',
            'company' => 'Công ty',
            default => 'Không xác định',
        };

        return
            "Đối tượng: " . $subjectType . "\n" .
            "SĐT: " . ($data['phone'] ?? '') . "\n" .
            "Email: " . ($data['email'] ?? '') . "\n" .
            "Nội dung: " . ($data['message'] ?? '');
    }
}