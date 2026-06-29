<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCommonFields;

class Incorporation extends Model
{
    use HasCommonFields;
    protected $fillable = ['name', 'active', 'ord'];

    public function jobs()
    {
        return $this->belongsToMany(
            Job::class,
            'job_incorporation_pivot',
            'incorporation_id',
            'job_id'
        );
    }
}
