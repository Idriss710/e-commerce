@extends('layouts.base')
@section('content')


  <div class="card mb-3" style="max-width: 540px;">
    <div class="card-header"><h5> Order Item</h5></div>
    <div class="row g-0">
      <div class="col-md-4">
        <img src="{{asset('assets/images/fashion/product/front')}}/{{$orderItem->product->image}}" class="img-fluid rounded-start" alt="{{asset('assets/images/fashion/product/front')}}/{{$orderItem->product->image}}">
      </div>
      <div class="col-md-8">
        <div class="card-body">
          <h5 class="card-title">{{$orderItem->product->name}}</h5>
          <p class="card-text">{{$orderItem->product->short_description}}.</p>
          <p class="card-text">QTY : {{$orderItem->quantity}}</p>
          <p class="card-text">Price : {{$orderItem->price}}</p>
          
          <p class="card-text p-4 back"><h5 class="text-body-secondary"> 
            @if ( $orderItem->status == 'ordered')
            <p class="text-success">Ordered On {{$orderItem->updated_at}}</p>
            @elseif( $orderItem->status == 'shipped')
            <p class="text-primary"> Shipped On {{$orderItem->updated_at}}</p>
            @elseif( $orderItem->status == 'pending')
                <p class="text-warning">Pending </p>
            @elseif( $orderItem->status == 'delivered')
                <p class="text-success">Delivered On {{$orderItem->updated_at}}</p>
            @elseif( $orderItem->status == 'canceled')
            <p class="text-danger">Canceled On {{$orderItem->updated_at}}
            @endif
          </h5></p>
          
        </div>
      </div>
    </div>
  </div>

  <div class="card p-2">
    <h3 class="card-header">PAYMENT METHOD</h3>
    <div class="card-body">
      <h4 class="card-title ">{{$orderItem->order->payment_method}}</h4>
    </div>
  </div>
  
  <div class="card">
    <h3 class="card-header">PAYMENT DERAILS</h3>
    <div class="card-body">
      <h5 class="card-title">Total : {{$orderItem->price}}</h5>
      <h5 class="card-title">Delivery Fees : {{$orderItem->fees}}</h5>
    </div>
  </div>
  
  <div class="card">
    <h3 class="card-header">DELIVERY</h3>
    <div class="card-body">
        <h4 class="card-title">Name : {{$orderItem->order->full_name}}</h4>
        <h4 class="card-title">Delivery Option : {{$orderItem->order->delivery_option}}</h4>
        <h4 class="card-title">Shipping Address : <h5>{{$orderItem->order->address}}</h5><h5>{{$orderItem->order->city}}  <h5>{{$orderItem->order->state}}</h5> <h5>{{$orderItem->order->country}}</h5> </h5></h4>
  </div>
@endsection