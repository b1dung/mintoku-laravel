<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCommonFields;

class Language extends Model // Thay Visa bằng Language, Experience...
{
    use HasCommonFields;
    protected $fillable = ['name', 'active', 'ord'];
}
