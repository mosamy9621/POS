<?php

namespace App\Policies;

use App\Category;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    public function before(){
        if(auth()->user()->hasRole('super_admin'))
            return true;
    }

    public  function ReadCategories(){
        return auth()->user()->hasPermission('read-categories');
        //  return (bool) auth()->user()->permissions()->where('name','read-Categories')->count();
        //return auth()->user()->can('read-Categories');

    }
    public  function EditCategories(){
        return auth()->user()->hasPermission('update-categories');

        // return (bool) auth()->user()->permissions()->where('name','update-Categories')->count();

    }
    public  function DeleteCategories(){

        return auth()->user()->hasPermission('delete-categories');

        // return (bool) auth()->user()->permissions()->where('name','delete-Categories')->count();

    }
    public  function CreateCategories(){

        return auth()->user()->hasPermission('create-categories');

        //return (bool) auth()->user()->permissions()->where('name','create-Categories')->count();

    }
}
