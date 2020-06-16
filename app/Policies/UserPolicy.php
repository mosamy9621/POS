<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;
    public function before(User $user){
        if($user->hasRole('super_admin'))
            return true;
    }

    public  function ReadUsers(){

        return auth()->user()->hasPermission('read-users');
        //  return (bool) auth()->user()->permissions()->where('name','read-users')->count();
        //return auth()->user()->can('read-users');

    }
    public  function EditUsers(User $user ,User $edited_user){
        return $user->hasPermission('update-users')
            && $user->id != $edited_user->id
            && $edited_user->hasRole('admin');

       // return (bool) auth()->user()->permissions()->where('name','update-users')->count();

    }
    public  function DeleteUsers(User $user ,User $edited_user){

        return $user->hasPermission('delete-users')

            && $edited_user->hasRole('admin')   ;

       // return (bool) auth()->user()->permissions()->where('name','delete-users')->count();

    }
    public  function CreateUsers(){

        return auth()->user()->hasPermission('create-users');

        //return (bool) auth()->user()->permissions()->where('name','create-users')->count();

    }
}
