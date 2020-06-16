<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('ReadUsers',auth()->user());
        $users = User::whereRoleIs('admin')->where('id','!=',auth()->user()->id);


        if($request->search){
          $users= User::whereRoleIs('admin')->where('name','like','%'.$request->search .'%')->where('id','!=',auth()->user()->id);
        }
        $users = $users->latest()->paginate(4);
        return view('dashboard.users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $this->authorize('CreateUsers',auth()->user());
        return (view('dashboard.users.create'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
           'name'=>['required'],
           'email'=>['required','email','unique:users'],
           'password'=>['required','confirmed','min:8','max:255'],
            'avatar'=>['file']

        ]);

       $requested_Data=$request->except(['password']);
       if($request->avatar) {
           $requested_Data['avatar'] = Image::make($request->avatar)->resize(150, null,
               function ($constrain) {
                   $constrain->aspectRatio();
               })
               ->save(public_path('Uploads\avatars\\' . $request->avatar->hashName()))->basename;
       }
       $requested_Data['password']=bcrypt($request['password']);

       $user=User::create($requested_Data);
       $user->attachRole('admin');
       /*
        * user who is not allowed to edit or delete can create another user who can
        **/
       $permissions=[];
       if($request['permissions']){
       foreach ($request['permissions'] as $premission)
       {
           if(auth()->user()->hasPermission($premission)){
               array_push($permissions,$premission);
           }

       }}
       $user->syncPermissions($permissions);
       session()->flash('success',__('site.added_successfully'));
       return redirect(route('dashboard.users.index'));


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('EditUsers',$user);
        return view('dashboard.users.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
            if(!$request['password']) {
                $request['password']=$request['password_confirmation']=$user->getAuthPassword();
            }
         $requested= $request->validate([
                'name' => ['required'],
                'email' => ['required', 'email', Rule::unique('users')->ignore($user)],
                'password' => ['confirmed', 'min:8', 'max:255']

            ]);

        if($request->avatar) {

            if($user->hasImage()){
                Storage::disk('public_uploads')->delete('/avatars/'.$user->avatar);
            }
            $requested['avatar'] = Image::make($request->avatar)->resize(150, null,
                function ($constrain) {
                    $constrain->aspectRatio();
                })
                ->save(public_path('Uploads\avatars\\' . $request->avatar->hashName()))->basename;
        }

            $user->update($requested);
            $permissions=[];

            foreach ($request['permissions'] as $premission)
            {
                if(auth()->user()->hasPermission($premission)){
                array_push($permissions,$premission);
            }
            }
            $user->syncPermissions($permissions);
            session()->flash('success',__('site.edited_successfully'));
            return redirect(route('dashboard.users.index'));


        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
        if($user->hasImage()){
           Storage::disk('public_uploads')->delete('/avatars/'.$user->avatar);
        }
        $this->authorize('DeleteUsers',auth()->user());
        $user->delete();
        session()->flash('success',__('site.deleted_successfully'));
        return redirect(route('dashboard.users.index'));


    }
}
