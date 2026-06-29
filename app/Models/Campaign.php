<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCommonFields;

class Campaign extends Model
{
    use HasCommonFields;
    protected $fillable = ['name', 'active', 'ord'];
}
