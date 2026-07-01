<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\RT;
use Illuminate\Auth\Access\HandlesAuthorization;

class RTPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:RT');
    }

    public function view(AuthUser $authUser, RT $rT): bool
    {
        return $authUser->can('View:RT');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:RT');
    }

    public function update(AuthUser $authUser, RT $rT): bool
    {
        return $authUser->can('Update:RT');
    }

    public function delete(AuthUser $authUser, RT $rT): bool
    {
        return $authUser->can('Delete:RT');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:RT');
    }

    public function restore(AuthUser $authUser, RT $rT): bool
    {
        return $authUser->can('Restore:RT');
    }

    public function forceDelete(AuthUser $authUser, RT $rT): bool
    {
        return $authUser->can('ForceDelete:RT');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:RT');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:RT');
    }

    public function replicate(AuthUser $authUser, RT $rT): bool
    {
        return $authUser->can('Replicate:RT');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:RT');
    }

}