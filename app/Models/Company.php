<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCommonFields;

class Company extends Model
{
    use HasCommonFields;
    protected $fillable = ['name', 'slug', 'logo', 'description', 'address', 'website', 'active', 'ord'];

    protected $casts = [
        'extra_attributes' => 'array',
    ];

    public function get_field(string $key, $default = null)
    {
        $value = data_get($this->extra_attributes ?? [], $key);
        if (is_null($value)) {
            $value = $this->getAttribute($key);
        }

        return $value ?? $default;
    }
}
