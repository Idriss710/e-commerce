<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;


class ShopController extends Controller
{
    public function index(){

        $prducts = Product::orderBy('created_at','DESC')->paginate(10);

        return view('shop',['products'=>$prducts]);
    }
    public function productDetails($slug){

        $product = Product::where('slug',$slug)->first();

        $rproducts = Product::where('slug','!=',$slug)->inRandomOrder('id')->get()->take(7);

        return view('details',['product'=>$product,'rproducts'=>$rproducts]);
    }

}
