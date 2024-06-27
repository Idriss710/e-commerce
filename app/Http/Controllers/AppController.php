<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartDB;
use App\Models\Product;
use App\Models\category;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;


class AppController extends Controller
{
    public function index(){
        // get cart count
        if (Auth::check())
        {
            $allQuantity = CartDB::where('user_id',Auth::id())->get('quantity');
            $cartCount = 0;
            if ($allQuantity)
             {
                foreach ($allQuantity as $q)
                {
                    $cartCount += $q->quantity ;
                }
             }
            session()->put('cartCount', $cartCount);   
        }else 
        {
            session()->put('cartCount', 0);
        }
        // get wishlist count
        if (Auth::check())
        {
            $wishlistCount = Wishlist::where('user_id',Auth::id())->get('id');
            $wishlistCount = $wishlistCount->count();
            session()->put('wishlistCount', $wishlistCount);  

        }else 
        {
            session()->put('wishlistCount', 0);
        }

        $products = Product::inRandomOrder('id')->get()->take(12);
        $rproducts = Product::inRandomOrder('id')->get()->take(12);
        $categories = Category::all();

        
        
        return view('index',['products'=>$products,'rproducts'=>$rproducts,'categories'=>$categories]);
    }
}
