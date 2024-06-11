<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CartDB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
////// add this line to use cart package 
use Cart ; 

class CartController extends Controller
{
    public function index(){
        $cartItems = Cart::instance('cart')->content();
        return view('cart',['cartItems'=>$cartItems]);
    }
    public function addToCart(Request $request){
        if (!Auth::check()) 
            return redirect()->route('login');

        $userID = Auth::id();
        
        $product = Product::find($request->id);
        $price = $product->sale_price ? $product->sale_price :  $product->reqular_price ;
        Cart::instance('cart')->add($product->id, $product->name,$request->quantity,$price)->associate('App\Models\Product');

        if ($product->id) {
        //update quantity if product already found 
            $quantity = DB::table('cart_d_b_s')->where('product_id',$product->id)->value('quantity');
            $quantity += $request->quantity;
            $affected = DB::table('cart_d_b_s')
              ->where('product_id',$product->id)
              ->update(['quantity' => $quantity]);
            }else{
        //add item to database cart tabel
        $cartDB = CartDB::create([
            'user_id'=>$userID,
            'product_id'=>$product->id,
            'quantity'=>$request->quantity
        ]);
                }   
        return redirect()->back()->with('message','Success! Item has been Added successfully ');
    }
    
    public function updateQuantity(Request $request){
        Cart::instance('cart')->update($request->rowId , $request->quantity);
        return redirect()->route('cart');
    }
    public function removeItem(Request $request){

        Cart::instance('cart')->remove($request->rowId);
        return redirect()->route('cart');
    }
    public function clearCart(){
        Cart::instance('cart')->destroy();
        return redirect()->back();
    }
}
