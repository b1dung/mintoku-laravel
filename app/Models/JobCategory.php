<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCommonFields;

class JobCategory extends Model
{
    use HasCommonFields;
    protected $fillable = ['parent_id', 'name', 'active', 'ord'];

    public function parent()
    {
        return $this->belongsTo(JobCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(JobCategory::class, 'parent_id');
    }

    public function jobs()
    {
        return $this->belongsToMany(Job::class, 'job_category_pivot', 'category_id', 'job_id');
    }
}
