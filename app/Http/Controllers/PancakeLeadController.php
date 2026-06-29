<?php

namespace App\Http\Controllers;

use App\Models\PancakeLead;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PancakeLeadController extends Controller
{
    public function store(Request $request): JsonResponse
    {
		   Log::info('Pancake webhook forbidden: invalid secret.', [
                    'ip' => $request->ip(),
                ]);
        $expectedSecret = env('LARAVEL_WEBHOOK_SECRET');

        if (!empty($expectedSecret)) {
            $receivedSecret = $request->header('X-Webhook-Secret');

            if ($receivedSecret !== $expectedSecret) {
                Log::warning('Pancake webhook forbidden: invalid secret.', [
                    'ip' => $request->ip(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Forbidden',
                ], 403);
            }
        }

        $payload = $request->all();

        $lead = $request->input('lead', []);
        $customer = $request->input('customer', []);
        $utm = $request->input('utm', []);
        $rawData = $request->input('raw_data', []);

        $pancakeId = $lead['pancake_id'] ?? null;

        if (empty($pancakeId)) {
            Log::warning('Pancake webhook missing pancake_id.', [
                'payload' => $payload,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Missing pancake_id',
            ], 422);
        }

        $record = PancakeLead::updateOrCreate(
            ['pancake_id' => $pancakeId],
            [
                'workspace_id' => $lead['workspace_id'] ?? null,
                'table_id' => $lead['table_id'] ?? null,

                'name' => $lead['name'] ?? null,
                'phone_number' => $lead['phone_number'] ?? null,
                'email' => $lead['email'] ?? null,
                'status' => $lead['status'] ?? null,
                'gender' => $lead['gender'] ?? null,

                'conversation_id' => $lead['conversation_id'] ?? null,
                'page_id' => $lead['page_id'] ?? null,
                'facebook_id' => $lead['facebook_id'] ?? null,
                'ref' => $lead['ref'] ?? null,
                'conversation_source' => $lead['conversation_source'] ?? null,

                'pancake_created_on' => $lead['created_on'] ?? null,
                'pancake_modified_on' => $lead['modified_on'] ?? null,

                'customer_data' => $customer,
                'utm_data' => $utm,
                'raw_data' => $rawData,
            ]
        );

        Log::info('Pancake lead saved.', [
            'id' => $record->id,
            'pancake_id' => $record->pancake_id,
            'name' => $record->name,
            'phone_number' => $record->phone_number,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pancake lead received successfully.',
            'data' => [
                'id' => $record->id,
                'pancake_id' => $record->pancake_id,
                'name' => $record->name,
                'phone_number' => $record->phone_number,
                'email' => $record->email,
                'status' => $record->status,
                'conversation_id' => $record->conversation_id,
                'ref' => $record->ref,
            ],
        ]);
    }
}