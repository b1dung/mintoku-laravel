<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCommonFields;

class Location extends Model
{
    use HasCommonFields;

    protected $fillable = ['parent_id', 'name', 'active', 'ord'];

    /**
     * Lấy danh sách địa điểm theo cấu trúc cha-con cho tìm kiếm
     */
    public static function getForSearch()
    {
        return self::where('active', 1)
            ->whereNull('parent_id') // Lấy các quốc gia/vùng lớn trước (VD: Việt Nam, Nhật Bản)
            ->with('children')      // Load kèm các tỉnh thành con
            ->orderBy('ord', 'asc')
            ->get();
    }

    /**
     * Quan hệ lấy các địa điểm con (tỉnh/thành)
     */
    public function children()
    {
        return $this->hasMany(Location::class, 'parent_id')->orderBy('ord', 'asc');
    }

    public function parent()
    {
        return $this->belongsTo(Location::class, 'parent_id');
    }

    public function jobs()
    {
        return $this->belongsToMany(Job::class, 'job_location_pivot', 'location_id', 'job_id');
    }
}
