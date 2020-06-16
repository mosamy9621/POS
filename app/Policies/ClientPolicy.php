<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
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

    public  function ReadClients(){
        return auth()->user()->hasPermission('read-clients');
        //  return (bool) auth()->user()->permissions()->where('name','read-Clients')->count();
        //return auth()->user()->can('read-Clients');

    }
    public  function EditClients(){
        return auth()->user()->hasPermission('update-clients');

        // return (bool) auth()->user()->permissions()->where('name','update-Clients')->count();

    }
    public  function DeleteClients(){

        return auth()->user()->hasPermission('delete-clients');

        // return (bool) auth()->user()->permissions()->where('name','delete-Clients')->count();

    }
    public  function CreateClients(){

        return auth()->user()->hasPermission('create-clients');

        //return (bool) auth()->user()->permissions()->where('name','create-Clients')->count();

    }
}
