<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'url',
        'description',
        'price'
    ];
    
    //relacionaentos
    public function category() 
    {
        return $this->belongsTo(Category::class);
    }
    
    //escopo global para ordernar valores
    public static function boot()
    {
        parent::boot();
        
        static::addGlobalScope('orderByPrice', function(Builder $builder) {
            $builder->orderBy('price','DESC');
        });
        
    }
}
