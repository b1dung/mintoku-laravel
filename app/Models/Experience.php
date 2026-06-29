<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCommonFields;

class Experience extends Model // Thay Visa bằng Language, Experience...
{
    use HasCommonFields;
    protected $fillable = ['name', 'active', 'ord'];
}
