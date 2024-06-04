<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;


class ShopController extends Controller
{
    public function index(Request $request){

        $page = $request->query('page');
        $size = $request->query('size');
        if(!$page)
            $page = 1 ;
        if(!$size)
            $size = 12 ;
        $prducts = Product::orderBy('created_at','DESC')->paginate($size);
        return view('shop',['products'=>$prducts , 'page'=>$page , 'size'=>$size]);
    }
    public function productDetails($slug){

        $product = Product::where('slug',$slug)->first();

        $rproducts = Product::where('slug','!=',$slug)->inRandomOrder('id')->get()->take(7);

        return view('details',['product'=>$product,'rproducts'=>$rproducts]);
    }

}
