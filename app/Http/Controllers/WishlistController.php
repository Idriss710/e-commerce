<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;

class WishlistController extends Controller
{
    public function addProductToWishlist(Request $request){
        Cart::instance("wishlist")->add($request->id,$request->name,1,$request->price)->associate('App\Models\Product');
        return response()->json(['status'=>200,'message'=>'Success added Product to your WishList']);
    }
    public function getWishlistedProducts(){
        $items = Cart::instance('wishlist')->content();
        return view('wishlist',['items'=>$items]); 
    }
    public function removeItemFromWishlist(Request $request){
        Cart::instance('wishlist')->remove($request->rowId);
        return redirect()->route('wishlist.list');
    }
}