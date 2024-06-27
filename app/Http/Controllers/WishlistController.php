<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

use Cart;

class WishlistController extends Controller
{
    public function index(){
        // get wishlist count
        if (Auth::check())
        {
            $wishlistCount = Wishlist::where('user_id',Auth::id())->get('id');
            $wishlistCount = $wishlistCount->count();
            session()->put('wishlistCount', $wishlistCount);  

        }else 
        {
            session()->put('wishlistCount', 0);
            return redirect()->route('login');
        }
        $items = Wishlist::where('user_id',Auth::id())->get();
        return view('wishlist',['items'=>$items]); 
    }

    public function addProductToWishlist(Request $request){
        // Cart::instance("wishlist")->add($request->id,$request->name,1,$request->price)->associate('App\Models\Product');

        if (!Auth::check()) 
            return redirect()->route('login');

        $userID = Auth::id();
        $is_allready_found = 0 ;
        $products = Wishlist::all('user_id','product_id');
        if($products)
        {
            foreach ( $products as $pro)
            {
                if($pro->user_id == $userID && $pro->product_id == $request->idd) 
                {
                    $is_allready_found = 1 ; 
                    break; 
                }
            }    
        }
        
        $message = '';
        if($is_allready_found == 1)
        {
            // return message allready is found
            $message = 'product allready found';

        }else{
            // add item to wishlist database tabel
            $wislist = Wishlist::create([
                'user_id'=>$userID,
                'product_id'=>$request->idd
                ]); 
            $message = 'Success added Product to your WishList';
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
        
                    
        return redirect()->back()->with('message','Success! Item has been Added successfully ');
        // return response()->json(['status'=>200,'message'=>$message]);
    }
    
    public function removeItemFromWishlist($id){
         $pro = Wishlist::where('user_id','=',Auth::id())->where('product_id','=',$id)->first();
            $pro->delete();
        // return redirect()->route('wishlist.list');
        return redirect()->back();
    }
    public function clearWishlist(){
        Wishlist::query()->delete();
        return redirect()->back();
    }

    public function getWishlistCount(){
        $cartCount =0;
        $wishlistCount =0;
        // get wishlist count
        if (Auth::check())
        {
            $wishlistCount = Wishlist::where('user_id',Auth::id())->get();
            $wishlistCount = $wishlistCount->count();
            session()->put('wishlistCount', $wishlistCount);   
        }else 
        {
            session()->put('wishlistCount', 0);
        }
        
        // return redirect()->back();
        return response()->json(['status'=>200,'cartCount'=>$cartCount,'wishlistCount'=>$wishlistCount]);
    }
}
