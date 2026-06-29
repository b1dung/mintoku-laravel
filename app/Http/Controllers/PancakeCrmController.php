<?php

namespace App\Http\Controllers;

use App\Services\PancakeCrmService;
use Illuminate\Http\Request;

class PancakeCrmController extends Controller
{
    public function storeLead(Request $request, PancakeCrmService $pancakeCrmService)
    {
        $validated = $request->validate([
            'full_name'    => 'required|string|max:255',
            'email'        => 'required|email|max:255',
            'phone'        => 'required|string|max:20',
            'subject_type' => 'nullable|in:individual,company',
            'message'      => 'nullable|string|max:2000',
        ]);

        $result = $pancakeCrmService->createLead($validated);

        return response()->json($result, $result['success'] ? 200 : 422);
    }
}