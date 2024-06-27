<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class OrderItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            $orderItems = OrderItem::with('order')->get();
            $orders = [];
            foreach ($orderItems as $o) {
                if($o->order->user_id == Auth::id())
                array_push($orders,$o);
            }
            return view('order.orderItems',['orderItems'=>$orders]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
             'product_id'=> 'required',
             'order_id'=> 'required',
             'price'=> 'required',
             'quantity'=> 'required'
        ]);

        OrderItem::create($data);
        
        // return redirect()->back();

    }

    /**
     * Display the specified resource.
     */
    public function show(OrderItem $orderItem)
    {
        return view('order.orderItemView',["orderItem"=>$orderItem]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrderItem $orderItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrderItem $orderItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderItem $orderItem)
    {
        //
    }
}
