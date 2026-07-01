<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Abj;
use Illuminate\Auth\Access\HandlesAuthorization;

class AbjPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Abj');
    }

    public function view(AuthUser $authUser, Abj $abj): bool
    {
        return $authUser->can('View:Abj');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Abj');
    }

    public function update(AuthUser $authUser, Abj $abj): bool
    {
        return $authUser->can('Update:Abj');
    }

    public function delete(AuthUser $authUser, Abj $abj): bool
    {
        return $authUser->can('Delete:Abj');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Abj');
    }

    public function restore(AuthUser $authUser, Abj $abj): bool
    {
        return $authUser->can('Restore:Abj');
    }

    public function forceDelete(AuthUser $authUser, Abj $abj): bool
    {
        return $authUser->can('ForceDelete:Abj');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Abj');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Abj');
    }

    public function replicate(AuthUser $authUser, Abj $abj): bool
    {
        return $authUser->can('Replicate:Abj');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Abj');
    }

}