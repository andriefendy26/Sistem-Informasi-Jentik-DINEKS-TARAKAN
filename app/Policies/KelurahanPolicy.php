<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Kelurahan;
use Illuminate\Auth\Access\HandlesAuthorization;

class KelurahanPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Kelurahan');
    }

    public function view(AuthUser $authUser, Kelurahan $kelurahan): bool
    {
        return $authUser->can('View:Kelurahan');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Kelurahan');
    }

    public function update(AuthUser $authUser, Kelurahan $kelurahan): bool
    {
        return $authUser->can('Update:Kelurahan');
    }

    public function delete(AuthUser $authUser, Kelurahan $kelurahan): bool
    {
        return $authUser->can('Delete:Kelurahan');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Kelurahan');
    }

    public function restore(AuthUser $authUser, Kelurahan $kelurahan): bool
    {
        return $authUser->can('Restore:Kelurahan');
    }

    public function forceDelete(AuthUser $authUser, Kelurahan $kelurahan): bool
    {
        return $authUser->can('ForceDelete:Kelurahan');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Kelurahan');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Kelurahan');
    }

    public function replicate(AuthUser $authUser, Kelurahan $kelurahan): bool
    {
        return $authUser->can('Replicate:Kelurahan');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Kelurahan');
    }

}