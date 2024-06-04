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
        $prducts = Product::orderBy($o_column,$o_order)->paginate($size);
        return view('shop',['products'=>$prducts , 'page'=>$page , 'size'=>$size, 'order'=>$order]);
    }
    public function productDetails($slug){

        $product = Product::where('slug',$slug)->first();

        $rproducts = Product::where('slug','!=',$slug)->inRandomOrder('id')->get()->take(7);

        return view('details',['product'=>$product,'rproducts'=>$rproducts]);
    }

}
