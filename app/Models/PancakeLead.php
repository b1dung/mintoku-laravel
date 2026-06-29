<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PancakeLead extends Model
{
    protected $table = 'pancake_leads';

    protected $guarded = [];

    protected $casts = [
        'customer_data' => 'array',
        'utm_data' => 'array',
        'raw_data' => 'array',
        'pancake_created_on' => 'datetime',
        'pancake_modified_on' => 'datetime',
    ];
}