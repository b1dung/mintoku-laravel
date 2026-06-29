<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeJob extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'active', 'ord'];
    public function jobs()
    {
        return $this->belongsToMany(Job::class, 'job_type_job', 'type_job_id', 'job_id');
    }
}
