<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable implements FilamentUser
{
    use Notifiable, HasRoles;

    protected $table = 'admins';

    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    /**
     * Filament v2 sử dụng canAccessFilament thay vì canAccessPanel
     */
    public function canAccessFilament(): bool
    {
        // Cho phép tất cả tài khoản trong bảng admins truy cập
        return true;
    }
}
