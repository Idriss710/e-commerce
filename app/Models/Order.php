<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable=['user_id',
    'tracking_no',
    'subtotal',
    'discount',
    'tax',
    'full_name',
    'phone',
    'locality',
    'address',
    'city',
    'state',
    'country',
    'landmark',
    'zip',
    'payment_mode'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function orderItem(){
        return $this->hasMany(OrderItem::class);
    }
    public function shipping(){
        return $this->hasOne(Shipping::class);
    }
    public function transaction(){
        return $this->hasOne(Transaction::class);
    }
}
