<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','avatar'
    ];
    protected $appends =[
        'avatarPath'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public  function  hasImage(){
        return (bool) $this->attributes['avatar'];
    }
    public  function getAvatarPathAttribute()
    {
        if(!$this->attributes['avatar']){
            $this->attributes['avatar']='temp.jpg';
        }
        return asset('Uploads/avatars/'.$this->attributes['avatar']);
    }
        public  function getAvatarAttribute(){

            return $this->attributes['avatar'];
    }
}
