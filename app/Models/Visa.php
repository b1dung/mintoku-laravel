<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCommonFields;

class Visa extends Model
{
    use HasCommonFields;
    protected $fillable = ['name', 'active', 'ord'];
}
