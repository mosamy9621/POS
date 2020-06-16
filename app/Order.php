<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $guarded=[];
    protected static $instance;

    public static function getInstance(){
        if(!self::$instance){
            self::$instance=self::class;
        }
        return self::$instance;
    }

    public function  products(){
        return $this->belongsToMany(Product::class);
    }
}
