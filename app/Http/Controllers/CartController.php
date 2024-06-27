<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CartDB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
////// add this line to use cart package 
use Cart ;

use Session;

class CartController extends Controller
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
        //get cart itmes releated to user
        $cartItems = CartDB::where('user_id',Auth::id())->get();
        $total_price = 0 ;
        return view('cart',['cartItems'=>$cartItems,'total_price'=>$total_price]);
    }
    public function addToCart(Request $request){
        if (!Auth::check()) 
            return redirect()->route('login');

        $userID = Auth::id();
        $is_already_found = 0 ;
        $products = CartDB::all('user_id','product_id');
        foreach ( $products as $pro)
        {
            if($pro->user_id == $userID && $pro->product_id == $request->id) 
            {
                $is_already_found = 1 ; 
                break; 
            }
        }
        
            if($is_already_found == 1)
            {
                //update quantity if product already found 
                $quantity = CartDB::where('user_id',$userID)->where('product_id',$request->id)->value('quantity');
                $quantity += $request->newQuantity;
                $affected = DB::table('cart_d_b_s')
                ->where('user_id',$userID)
                ->where('product_id',$request->id)
                ->update(['quantity' => $quantity]);

            }else{
           // add item to cart database tabel
                $cartDB = CartDB::create([
                'user_id'=>$userID,
                'product_id'=>$request->id,
                'quantity'=>$request->newQuantity,
                 ]); 
            }
        
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
           
                       
        return redirect()->back()->with('message','Success! Item has been Added successfully ');
    }
    
    public function updateQuantity(Request $request){
        //update Cart quantity 
        $userID = Auth::id();
        $quantity = $request->quantity;
        $affected = DB::table('cart_d_b_s')
        ->where('user_id',$userID)
        ->where('product_id',$request->id)
        ->update(['quantity' => $quantity]);
        return redirect()->route('cart');
    }
    public function removeItem(Request $request){

        $pro = CartDB::where('user_id','=',Auth::id())->where('product_id','=',$request->rowId)->first();
            $pro->delete();
        
        return redirect()->back();
        
    }
    public function clearCart(){
        CartDB::query()->delete();
        return redirect()->back();
    }
}
