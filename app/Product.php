<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable= ['name','description','purchased_price','selling_price','image','stock'];
    protected $appends =['imagePath','profit_percentage'];
    protected static $instance;
    public  function category(){
        return $this->belongsTo(Category::class);
    }

    public  function getImagePathAttribute()
    {
        if(!$this->attributes['image']){
            $this->attributes['image']='temp.jpg';
        }
        return asset('Uploads/products/'.$this->attributes['image']);
    }
    public  function getImageAttribute(){

        return $this->attributes['image'];
    }
    public  function getProfitPercentageAttribute(){
        $profit = ($this->selling_price - $this->purchased_price)/$this->purchased_price *100;
        return  number_format($profit,2);
    }

    public  function hasImage(){
        return (bool)$this->attributes['image'];
    }
    public  static  function getInstance(){
        if(!self::$instance){
            self::$instance= self::class ;

        }
        return self::$instance;
    }

    public function orders(){
        return $this->belongsToMany(Order::class);
    }
}
