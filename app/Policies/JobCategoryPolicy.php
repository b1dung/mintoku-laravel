<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\JobCategory;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobCategoryPolicy
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
        return $admin->can('view_any_job::category');
    }

    /**
     * Determine whether the admin can view the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\JobCategory  $jobCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Admin $admin, JobCategory $jobCategory): bool
    {
        return $admin->can('view_job::category');
    }

    /**
     * Determine whether the admin can create models.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Admin $admin): bool
    {
        return $admin->can('create_job::category');
    }

    /**
     * Determine whether the admin can update the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\JobCategory  $jobCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Admin $admin, JobCategory $jobCategory): bool
    {
        return $admin->can('update_job::category');
    }

    /**
     * Determine whether the admin can delete the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\JobCategory  $jobCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Admin $admin, JobCategory $jobCategory): bool
    {
        return $admin->can('delete_job::category');
    }

    /**
     * Determine whether the admin can bulk delete.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deleteAny(Admin $admin): bool
    {
        return $admin->can('delete_any_job::category');
    }

    /**
     * Determine whether the admin can permanently delete.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\JobCategory  $jobCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Admin $admin, JobCategory $jobCategory): bool
    {
        return $admin->can('force_delete_job::category');
    }

    /**
     * Determine whether the admin can permanently bulk delete.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDeleteAny(Admin $admin): bool
    {
        return $admin->can('force_delete_any_job::category');
    }

    /**
     * Determine whether the admin can restore.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\JobCategory  $jobCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Admin $admin, JobCategory $jobCategory): bool
    {
        return $admin->can('restore_job::category');
    }

    /**
     * Determine whether the admin can bulk restore.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restoreAny(Admin $admin): bool
    {
        return $admin->can('restore_any_job::category');
    }

    /**
     * Determine whether the admin can replicate.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\JobCategory  $jobCategory
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function replicate(Admin $admin, JobCategory $jobCategory): bool
    {
        return $admin->can('replicate_job::category');
    }

    /**
     * Determine whether the admin can reorder.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function reorder(Admin $admin): bool
    {
        return $admin->can('reorder_job::category');
    }

}
