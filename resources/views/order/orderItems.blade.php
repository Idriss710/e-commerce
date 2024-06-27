@extends('layouts.base')
@section('content')

@if (count($orderItems) == 0)

  <div class="card text-center">
    
    <div class="card-body">
      <h5 class="card-title">You don't have order yet</h5>
      <a href="{{route('shop')}}" class="btn btn-primary">Go Shopping</a>
    </div>
   
  </div>
  
@else

  <div class="table-responsive">
    <table class="table cart-table">
        <thead>
            <tr class="table-head">
                <th scope="col">image</th>
                <th scope="col">Order Id</th>
                <th scope="col">Product Details</th>
                <th scope="col">Status</th>
                <th scope="col">Price</th>
                <th scope="col">View</th>
            </tr>
        </thead>
        <tbody>
          @foreach ($orderItems as $orderItem)
          <tr>
            <td>
                <a href="details.php">
                    <img src="{{asset('assets/images/fashion/product/front')}}/{{$orderItem->product->image}}" class="blur-up lazyload" alt="">
                </a>
            </td>
            <td>
                <p class="mt-0">#{{$orderItem->order->id}}</p>
            </td>
            <td>
                <p class="fs-6 m-0">{{$orderItem->product->name}}</p>
            </td>
            @if ($orderItem->status == 'ordered')
  
              <td>
                <p class="success-button btn btn-sm">Ordered</p>
              </td>
            @elseif($orderItem->status == 'pending') 
            <td>
              <p class="danger-button btn btn-sm">Pending</p>
            </td> 
            @elseif($orderItem->status == 'shipped') 
            <td>
              <p class="warning-button btn btn-sm">Shipped</p>
            </td> 
            @elseif($orderItem->status == 'delivered' ) 
            <td>
              <p class="success-button btn btn-sm">Delivered</p>
            </td> 
            @elseif($orderItem->status == 'canceled' ) 
            <td>
              <p class="danger-button btn btn-sm">Canceled</p>
            </td> 
           
            @endif
            
            <td>
                <p class="theme-color fs-6">{{$orderItem->price}}</p>
            </td>
            <td>
                <a href="{{route('orderItems.show',['orderItem'=>$orderItem])}}">
                    <i class="far fa-eye"></i>
                </a>
            </td>
        </tr>
          @endforeach
            
  
        </tbody>
    </table>
  </div>

    
@endif

@endsection