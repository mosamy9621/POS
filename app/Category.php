<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected  static $categoryObj;
    protected $fillable = ['name'];

    public  static function getInstance(){
        if(!self::$categoryObj){
                self::$categoryObj=self::class;
        }
        return self::$categoryObj;
    }

    public  function products(){
       return $this->hasMany(Product::class);
    }//
}
