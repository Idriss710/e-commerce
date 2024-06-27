<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CartDB;

use Illuminate\Support\Facades\Auth;

use Cart;


class ShopController extends Controller
{
    public function index(Request $request){
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

        $page = $request->query('page');
        $size = $request->query('size');
        if(!$page)
            $page = 1 ;
        if(!$size)
            $size = 12 ;
        $order = $request->query('order');
        if(!$order)
        $order = -1;
        $o_column = '';
        $o_order = '';
        switch ($order) {
            case 1:
            $o_column = 'created_at';
            $o_order = 'DESC';      // new to old DESC
            break;
            case 2:
            $o_column = 'created_at';
            $o_order = 'ASC';       // old to new ASC
            break;
            case 3:
            $o_column = 'reqular_price';
            $o_order = 'ASC';       //low to high ASC
            break;
            case 4:
            $o_column = 'reqular_price'; 
            $o_order = 'DESC';      // high price to low DESC
            break;
            default:
            $o_column = 'id';
            $o_order = 'DESC';
            break;
        }
        $brands = Brand::orderBy('name','ASC')->get();
        $categories = Category::orderBy('name','ASC')->get();
        $q_brands = $request->query('brands');                  // the same like   $request->brands 
        $q_categories = $request->query('categories');          // the same like   $request->categories 
        $prange = $request->query('prange');
        if (!$prange)
            $prange = '0,500';
        $from = explode(',',$prange)[0];
        $to = explode(',',$prange)[1];
        $prducts = Product::where(function($query) use($q_brands){
                $query->whereIn('brand_id',explode(',',$q_brands))->orWhereRaw("'".$q_brands."'=''");
            })->where(function($query) use($q_categories){
                $query->whereIn('category_id',explode(',',$q_categories))->orWhereRaw("'".$q_categories."'=''");
            })
            ->whereBetween('reqular_price',array($from,$to))
            ->orderBy($o_column,$o_order)->paginate($size);
        return view('shop',['products'=>$prducts , 'page'=>$page , 'size'=>$size, 'order'=>$order , 'brands'=>$brands,'q_brands'=>$q_brands,'categories'=>$categories,'q_categories'=>$q_categories,'from'=>$from,'to'=>$to]);
    }
    public function productDetails($slug){

        $product = Product::where('slug',$slug)->first();

        $rproducts = Product::where('slug','!=',$slug)->inRandomOrder('id')->get()->take(7);

        $productSize = Product::where('slug',$slug)->value('size');
        
        
        

        return view('details',['product'=>$product,'rproducts'=>$rproducts,'productSize'=>$productSize]);
    }
    public function getCartAndWishlistCount(){
        $cartCount = Cart::instance('cart')->content()->count();
        $wishlistCount = Cart::instance('wishlist')->content()->count();
        return response()->json(['status'=>200,'cartCount'=>$cartCount,'wishlistCount'=>$wishlistCount]);
    }

}
