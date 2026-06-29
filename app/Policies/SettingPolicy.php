<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Setting;
use Illuminate\Auth\Access\HandlesAuthorization;

class SettingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the admin can view any models.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(Admin $admin): bool
    {
        return $admin->can('view_any_setting');
    }

    /**
     * Determine whether the admin can view the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Admin $admin, Setting $setting): bool
    {
        return $admin->can('view_setting');
    }

    /**
     * Determine whether the admin can create models.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Admin $admin): bool
    {
        return $admin->can('create_setting');
    }

    /**
     * Determine whether the admin can update the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Admin $admin, Setting $setting): bool
    {
        return $admin->can('update_setting');
    }

    /**
     * Determine whether the admin can delete the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Admin $admin, Setting $setting): bool
    {
        return $admin->can('delete_setting');
    }

    /**
     * Determine whether the admin can bulk delete.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deleteAny(Admin $admin): bool
    {
        return $admin->can('delete_any_setting');
    }

    /**
     * Determine whether the admin can permanently delete.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Admin $admin, Setting $setting): bool
    {
        return $admin->can('force_delete_setting');
    }

    /**
     * Determine whether the admin can permanently bulk delete.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDeleteAny(Admin $admin): bool
    {
        return $admin->can('force_delete_any_setting');
    }

    /**
     * Determine whether the admin can restore.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Admin $admin, Setting $setting): bool
    {
        return $admin->can('restore_setting');
    }

    /**
     * Determine whether the admin can bulk restore.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restoreAny(Admin $admin): bool
    {
        return $admin->can('restore_any_setting');
    }

    /**
     * Determine whether the admin can replicate.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Setting  $setting
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function replicate(Admin $admin, Setting $setting): bool
    {
        return $admin->can('replicate_setting');
    }

    /**
     * Determine whether the admin can reorder.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function reorder(Admin $admin): bool
    {
        return $admin->can('reorder_setting');
    }

}
