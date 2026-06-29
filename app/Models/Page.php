<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'status',
        'sort_order',
        'seo_title',
        'seo_description',
    ];
}
