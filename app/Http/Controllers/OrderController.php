<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CartDB;
use App\Models\OrderItem;



class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
        $cart = CartDB::where('user_id',Auth::id())->get();
        $subtotal = 0 ;
        foreach ($cart as $ca) {
            if ($ca->product->sale_price == null or $ca->product->sale_price == 0)
            {
                    $subtotal += $ca->product->reqular_price * $ca->quantity ;
            }else
            {
                $subtotal += $ca->product->sale_price * $ca->quantity ;
            }
             
        }

        return view('order.checkout',['subtotal'=>$subtotal]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->request->add(['user_id' => Auth::id()]);
        $request->request->add([ 'tracking_no' => mt_rand(10000000, 99999999) ]);

        $data = $request->validate([
            'user_id'=>'required',
            'tracking_no'=>'required | numeric',
            'subtotal'=>'required',
            'discount'=>'nullable',
            'tax'=>'nullable',
            'full_name'=>'required',
            'phone'=>'required | numeric | digits_between:1,15 ',
            'locality'=>'required',
            'address'=>'required',
            'city'=>'required',
            'state'=>'required',
            'country'=>'required',
            'landmark'=>'nullable',
            'zip'=>'nullable',
            'payment_method'=>'required',
            'delivery_option'=>'required'
        ]);
       
        $data = request()->except(['_token', '_method']);
        $order =  Order::create($data);
        // dd($order);
        $allProducts = CartDB::where('user_id',Auth::id())->get();
        // $quantity = 0 ;
        $price = 0 ;

        // foreach ($allProducts as $product) {
        //     $quantity += $product->quantity;
        // }

        foreach ($allProducts as $product)
        {
            $myRequest = new \Illuminate\Http\Request();
            $myRequest->setMethod('POST');
            // for get price 
            if ( $product->product->sale_price == null or $product->product->sale_price == 0)
            {
                $price = $product->product->reqular_price * $product->quantity ;
            }else
            {
                $price = $product->product->sale_price * $product->quantity ;
            }
            $myRequest->request->add([
                'product_id' => $product->product_id,
                'order_id' => $order->id,
                'price' => $price,
                'quantity' => $product->quantity
                
            ]);
            $newOrderItem = $myRequest->all();
             OrderItem::create($newOrderItem);
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
