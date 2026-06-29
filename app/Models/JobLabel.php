<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobLabel extends Model
{
    protected $table = 'job_labels';

    protected $fillable = [
        'name',
        'slug',
        'active',
        'ord'
    ];
    public function jobs()
    {
        return $this->belongsToMany(
            Job::class,
            'job_label_pivot',
            'label_id',
            'job_id'
        )
            ->withPivot('id', 'active', 'ord')
            ->withTimestamps();
    }
}
