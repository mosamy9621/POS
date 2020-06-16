<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function before(){

        if(auth()->user()->hasRole('super_admin'))
            return true;
    }

    public  function ReadOrders(){
        return auth()->user()->hasPermission('read-orders');
        //  return (bool) auth()->user()->permissions()->where('name','read-Orders')->count();
        //return auth()->user()->can('read-Orders');

    }
    public  function EditOrders(){
        return auth()->user()->hasPermission('update-orders');

        // return (bool) auth()->user()->permissions()->where('name','update-Orders')->count();

    }
    public  function DeleteOrders(){

        return auth()->user()->hasPermission('delete-orders');

        // return (bool) auth()->user()->permissions()->where('name','delete-Orders')->count();

    }
    public  function CreateOrders(){

        return auth()->user()->hasPermission('create-orders');

        //return (bool) auth()->user()->permissions()->where('name','create-Orders')->count();

    }
}
