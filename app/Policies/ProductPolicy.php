<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    public function before(){
        if(auth()->user()->hasRole('super_admin'))
            return true;
    }
    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public  function ReadProducts(){
        return auth()->user()->hasPermission('read-products');
        //  return (bool) auth()->user()->permissions()->where('name','read-Products')->count();
        //return auth()->user()->can('read-Products');

    }
    public  function EditProducts(){
        return auth()->user()->hasPermission('update-products');

        // return (bool) auth()->user()->permissions()->where('name','update-Products')->count();

    }
    public  function DeleteProducts(){

        return auth()->user()->hasPermission('delete-products');

        // return (bool) auth()->user()->permissions()->where('name','delete-Products')->count();

    }
    public  function CreateProducts(){

        return auth()->user()->hasPermission('create-products');

        //return (bool) auth()->user()->permissions()->where('name','create-Products')->count();

    }
}
