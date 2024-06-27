<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public function brand(){
        return $this->belongsTo(Brand::class,'brand_id');
    }
    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }
    // public function cartdb(){
    //     return $this->belongsTo(CartDB::class,'category_id');
    // }
    
}
