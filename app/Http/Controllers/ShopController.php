<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;


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
        $brands = Brand::orderBy('name','ASC')->get();
        $q_brands = $request->query('brands');
        $prducts = Product::where(function($query) use($q_brands){
                $query->whereIn('brand_id',explode(',',$q_brands))->orWhereRaw("'".$q_brands."'=''");
            })
            ->orderBy($o_column,$o_order)->paginate($size);
        return view('shop',['products'=>$prducts , 'page'=>$page , 'size'=>$size, 'order'=>$order , 'brands'=>$brands,'q_brands'=>$q_brands]);
    }
    public function productDetails($slug){

        $product = Product::where('slug',$slug)->first();

        $rproducts = Product::where('slug','!=',$slug)->inRandomOrder('id')->get()->take(7);

        return view('details',['product'=>$product,'rproducts'=>$rproducts]);
    }

}
