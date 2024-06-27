@extends('layouts.base')
@section('content')
<section class="breadcrumb-section section-b-space" style="padding-top:20px;padding-bottom:20px;">
    <ul class="circles">
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
    </ul>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3>Cart</h3>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('index')}}">
                                <i class="fas fa-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Cart</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Cart Section Start -->
<section class="cart-section section-b-space">
    <div class="container">
        @if ($cartItems->count() > 0)
            
                
            
        <div class="row">
            <div class="col-md-12 text-center">
                <table class="table cart-table">
                    <thead>
                        <tr class="table-head">
                            <th scope="col">image</th>
                            <th scope="col">product name</th>
                            <th scope="col">sale price</th>
                            <th scope="col">reqular price</th>
                            <th scope="col">quantity</th>
                            <th scope="col">total</th>
                            <th scope="col">action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($cartItems as $item)
                        <tr>
                            <td>
                                <a href="{{route('productDetails',['slug'=>$item->product->slug])}}">
                                    <img src="{{asset('assets/images/fashion/product/front')}}/{{$item->product->image}}" class="blur-up lazyloaded"
                                        alt="">
                                </a>
                            </td>
                            <td>
                                <a href="../product/details.html">{{$item->product->name}}</a>
                                <div class="mobile-cart-content row">
                                    <div class="col">
                                        <div class="qty-box">
                                            <div class="input-group">
                                                <input type="text" name="quantity" class="form-control input-number"
                                                    value="1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <h2>$90</h2>
                                    </div>
                                    <div class="col">
                                        <h2 class="td-color">
                                            <a href="javascript:void(0)">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </h2>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <h2>${{$item->product->sale_price}}</h2>
                            </td>
                            <td>
                                <h2>${{$item->product->reqular_price}}</h2>
                            </td>
                            <td>
                                <div class="qty-box">
                                    <div class="input-group">
                                        <input type="number" name="quantity" 
                                            data-rowid="{{$item->product_id}}" onchange="updateQuantity(this)"
                                            class="form-control input-number" value="{{$item->quantity}}">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <h2 class="td-color">
                                    @if ($item->product->sale_price == null or $item->product->sale_price == 0)
                                        {{$item->product->reqular_price * $item->quantity}}
                                        @php $total_price += $item->product->reqular_price * $item->quantity @endphp
                                        @else
                                        {{$item->product->sale_price * $item->quantity}}
                                        @php $total_price += $item->product->sale_price * $item->quantity @endphp
                                    @endif 
                                 </h2>
                            </td>
                            <td>
                                <a href="javascript:void(0)" onclick="removeItem('{{$item->product_id}}')"  >
                                    <i class="fas fa-times"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                       
                    </tbody>
                </table>
            </div>


        
        <div class="col-12 mt-md-5 mt-4">
            <div class="row">
                <div class="col-sm-7 col-5 order-1">
                    <div class="left-side-button text-end d-flex d-block justify-content-end">
                        <a href="javascript:void(0)" onclick="clearCart()"
                            class="text-decoration-underline theme-color d-block text-capitalize">clear
                            all items</a>
                    </div>
                </div>
                <div class="col-sm-5 col-7">
                    <div class="left-side-button float-start">
                        <a href="{{route('shop')}}" class="btn btn-solid-default btn fw-bold mb-0 ms-0">
                            <i class="fas fa-arrow-left"></i> Continue Shopping</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="cart-checkout-section">
            <div class="row g-4">
                

                <div class="col-lg-4 col-sm-6 ">
                    <div class="checkout-button">
                        <a href="{{route('order.index')}}" class="btn btn-solid-default btn fw-bold">
                            Check Out <i class="fas fa-arrow-right ms-1"></i></a>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="cart-box">
                        <div class="cart-box-details">
                            <div class="total-details">
                                <div class="top-details">
                                    <h3>Cart Totals</h3>
                                    <h6>Sub Total <span>${{$total_price}}</span></h6>
                                    <h6>Taxs <span>$0</span></h6>

                                    <h6>Total <span>${{$total_price}}</span></h6>
                                </div>
                                <div class="bottom-details">
                                    <a href="{{route('order.index')}}">Process Checkout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        </div>
        @else
        <div class="col-md-12 text-center">
            <h2>No Items in your cart</h2>
            <div class="col-12 mt-md-5 mt-4">
                    <div class="col-sm-5 col-7">
                        <div class="left-side-button float-start">
                            <a href="{{route('shop')}}" class="btn btn-solid-default btn fw-bold mb-0 ms-0">
                                <i class="fas fa-arrow-left"></i> Continue Shopping</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
<form id="updataCartQty" action="{{route('cart.update')}}" method="post">
    @csrf
    @method('put')
    <input type="hidden" id="id" name="id">
    <input type="hidden" id="quantity" name="quantity">
</form>
<form id="deleteItem" action="{{route('cart.remove')}}" method="post">
    @csrf
    @method('delete')
    <input type="hidden" id="rowId_D" name="rowId">
</form>
<form id="clearID" action="{{route('cart.clear')}}" method="post">
    @csrf
    @method('delete')
</form>

@endsection
@push('scripts')
    <script>

        function updateQuantity(data){

            $("#id").val($(data).data('rowid'));
            $('#quantity').val($(data).val());
            $('#updataCartQty').submit();
        }
        function removeItem(rowId){
            
            $("#rowId_D").val(rowId);
            $('#deleteItem').submit();
        }
        function clearCart(){
            $('#clearID').submit();
        }
        
    </script>
@endpush