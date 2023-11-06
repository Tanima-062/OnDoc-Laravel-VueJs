<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        $routeName = Route::currentRouteName(); // string

        if($routeName == 'company-admins.index') {
            return $user->type == User::SYSTEM_ADMIN;
        }
        else if($routeName == 'company-sub-admins.index'){
           return $user->type == User::COMPANY_ADMIN;
        }

        return false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        $routeName = Route::currentRouteName(); // string

        // info($routeName);

        // return true;

        if($routeName == 'company-admins.create') {
            return $user->type == User::SYSTEM_ADMIN;
        }
        else if($routeName == 'company-sub-admins.create'){
           return $user->type == User::COMPANY_ADMIN;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, User $model)
    {
        $routeName = Route::currentRouteName(); // string

        if($routeName == 'company-admins.edit' || $routeName == 'company-admins.update') {
            return $user->type == User::SYSTEM_ADMIN;
        }
        else if($routeName == 'company-sub-admins.edit' || $routeName == 'company-sub-admins.update'){
           return (($user->type == User::COMPANY_ADMIN) && ($user->company_id == $model->company_id));
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, User $model)
    {

    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, User $model)
    {
        //
    }
}
