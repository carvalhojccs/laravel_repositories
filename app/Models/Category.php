<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['title', 'url', 'descrition'];
    
    //relacionamentos
    public function products() 
    {
        return $this->hasMany(Product::class);
    }
}
