@extends('layouts.base')
@section('content')
<style>
    a.disabled,
    a.disabled:hover .fas {
        color: grey !important;
        cursor: not-allowed;
    }
</style>
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
                <h3>Wishlist</h3>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('index')}}">
                                <i class="fas fa-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Wishlist</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<!-- Cart Section Start -->
<section class="wish-list-section section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 table-responsive">
                <table class="table cart-table wishlist-table">
                    <thead>
                        <tr class="table-head">
                            <th scope="col">image</th>
                            <th scope="col">product name</th>
                            <th scope="col">price</th>
                            <th scope="col">availability</th>
                            <th scope="col">action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>
                                    <a href="{{route('productDetails',['slug'=>$item->model->slug])}}">
                                        <img src="{{asset('assets/images/fashion/product/front')}}/{{$item->model->image}}"
                                            class=" blur-up lazyload" alt="{{$item->model->image}}">
                                    </a>
                                </td>
                                <td>
                                    <a href="{{route('productDetails',['slug'=>$item->model->slug])}}" class="font-light">{{$item->model->name}}</a>
                                    <div class="mobile-cart-content row">
                                        <div class="col">
                                            <p>{{$item->model->stock_status}}</p>
                                        </div>
                                        <div class="col">
                                            <p class="fw-bold">$@if ($item->model->sale_price) {{$item->model->sale_price}} @else {{$item->model->raqular_price}}  @endif </p>
                                        </div>
                                        <div class="col">
                                            <h2 class="td-color">
                                                <a href="javascript:void(0)" class="icon">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            </h2>
                                            <h2 class="td-color">
                                                <a href="cart.php" class="icon">
                                                    <i class="fas fa-shopping-cart"></i>
                                                </a>
                                            </h2>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="fw-bold">$@if ($item->model->sale_price) {{$item->model->sale_price}} @else {{$item->model->raqular_price}}  @endif </p>
                                </td>
                                <td>
                                    <p>{{$item->model->stock_status}}</p>
                                </td>
                                <td>

                                    <a href="javascript:void(0)" class="icon">
                                        <i class="fas fa-shopping-cart"></i>
                                    </a>
                                    <a href="javascript:void(0)" class="icon">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </td>
                            </tr>  
                        @endforeach
                                                 
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<!-- Cart Section End -->   

@endsection
