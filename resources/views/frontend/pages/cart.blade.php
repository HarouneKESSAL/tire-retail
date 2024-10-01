@php use Illuminate\Support\Facades\Session; @endphp
@extends('frontend.layouts.master')
@section('title','Cart Page')
@section('main-content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{('home')}}">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="">Cart</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Shopping Cart -->
    <div class="shopping-cart section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Shopping Summary -->
                    <table class="table shopping-summary">
                        <thead>
                        <tr class="main-heading">
                            <th>PRODUCT</th>
                            <th>NAME</th>
                            <th class="text-center">UNIT PRICE</th>
                            <th class="text-center">QUANTITY</th>
                            <th class="text-center">TOTAL</th>
                            <th class="text-center"><i class="ti-trash remove-icon"></i></th>
                        </tr>
                        </thead>
                        <tbody id="cart_item_list">
                        <form action="{{ route('cart.update') }}" method="POST">
                            @csrf
                            @if(Helper::getAllProductFromCart())
                                @foreach(Helper::getAllProductFromCart() as $key => $cart)
                                    <tr>
                                        @php
                                            $photo = explode(',', $cart->product['photo']);
                                        @endphp
                                        <td class="image" data-title="No">
                                            <img src="{{ $photo[0] }}" alt="{{ $photo[0] }}" style="max-width: 100px;">
                                        </td>
                                        <td class="product-des" data-title="Description">
                                            <p class="product-name">
                                                <a href="{{ route('product-detail', $cart->product['slug']) }}" target="_blank">
                                                    {{ $cart->product['title'] }}
                                                </a>
                                            </p>
                                            <p class="product-des">{!! $cart['summary'] !!}</p>
                                        </td>
                                        <td class="price" data-title="Price">
                                            <span>${{ number_format($cart['price'], 2) }}</span>
                                        </td>
                                        <td class="qty" data-title="Qty">
                                            <div class="input-group" style="display: flex; align-items: center;">
                                                <div class="button minus">
                                                    <button type="button" class="btn btn-danger btn-number" data-type="minus" data-field="quant[{{ $key }}]">
                                                        <i class="ti-minus"></i>
                                                    </button>
                                                </div>
                                                <input type="text" name="quant[{{ $key }}]" class="input-number" data-min="1" data-max="100" value="{{ $cart->quantity }}" style="text-align: center; width: 50px; margin: 0 10px;">
                                                <input type="hidden" name="qty_id[]" value="{{ $cart->id }}">
                                                <div class="button plus">
                                                    <button type="button" class="btn btn-danger btn-number" data-type="plus" data-field="quant[{{ $key }}]">
                                                        <i class="ti-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-title="Total">
                                            <span class="money">${{ $cart['amount'] }}</span>
                                        </td>
                                        <td class="action" data-title="Remove">
                                            <a href="{{ route('cart-delete', $cart->id) }}">
                                                <i class="ti-trash remove-icon"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="6" class="float-right">
                                        <button class="btn float-right" type="submit">Update</button>
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td class="text-center" colspan="6">
                                        There are no carts available. <a href="{{ route('product-grids') }}" style="color:blue;">Continue shopping</a>
                                    </td>
                                </tr>
                            @endif
                        </form>
                        </tbody>
                    </table>
                    <!--/ End Shopping Summary -->
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <!-- Total Amount -->
                    <div class="total-amount">
                        <div class="row">
                            <div class="col-lg-8 col-md-5 col-12">
                                <div class="left">
                                    <div class="coupon">
                                        <form action="{{ route('coupon-store') }}" method="POST" class="coupon-form">
                                            @csrf
                                            <div class="input-group">
                                                <input name="code" placeholder="Enter Your Coupon" class="form-control" required>
                                                <button class="btn btn-danger" type="submit">Apply</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-7 col-12">
                                <div class="cart-summary right">
                                    <ul>
                                        <li class="subtotal" data-price="{{ Helper::totalCartPrice() }}">
                                            <span class="label">Cart Subtotal:</span>
                                            <span class="value">${{ number_format(Helper::totalCartPrice(), 2) }}</span>
                                        </li>

                                        @if(session()->has('coupon'))
                                            <li class="savings" data-price="{{ Session::get('coupon')['value'] }}">
                                                <span class="label">You Save:</span>
                                                <span class="value">${{ number_format(Session::get('coupon')['value'], 2) }}</span>
                                            </li>
                                        @endif

                                        @php
                                            $total_amount = Helper::totalCartPrice();
                                            if (session()->has('coupon')) {
                                                $total_amount -= Session::get('coupon')['value'];
                                            }
                                        @endphp

                                        <li class="total" id="order_total_price">
                                            <span class="label">You Pay:</span>
                                            <span class="value">${{ number_format($total_amount, 2) }}</span>
                                        </li>
                                    </ul>

                                    <div class="button">
                                        <a href="{{ route('checkout') }}" class="btn btn-danger">Checkout</a>
                                        <a href="{{ route('product-grids') }}" class="btn btn-danger">Continue shopping</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ End Total Amount -->
                </div>
            </div>
        </div>
    </div>
    <!--/ End Shopping Cart -->

    <!-- Start Shop Services Area  -->
    <section class="shop-services section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-rocket"></i>
                        <h4>Free shiping</h4>
                        <p>Orders over $100</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-reload"></i>
                        <h4>Free Return</h4>
                        <p>Within 30 days returns</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-lock"></i>
                        <h4>Sucure Payment</h4>
                        <p>100% secure payment</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-tag"></i>
                        <h4>Best Peice</h4>
                        <p>Guaranteed price</p>
                    </div>
                    <!-- End Single Service -->
                </div>
            </div>
        </div>
    </section>
    <!-- End Shop Newsletter -->

    <!-- Start Shop Newsletter  -->
    @include('frontend.layouts.newsletter')
    <!-- End Shop Newsletter -->

@endsection
@push('styles')
    <style>
        .coupon-form {
            margin-top: 20px;
        }

        .coupon-form .input-group {
            display: flex;
            align-items: center;
            max-width: 300px;
            margin: 0 auto;
        }

        .coupon-form .form-control {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px 0 0 5px;
            font-size: 14px;
        }

        .coupon-form .btn-danger {
            padding: 10px 20px;
            border-radius: 0 5px 5px 0;
            font-size: 14px;
            font-weight: bold;
        }

        .coupon-form .btn-danger:hover {
            background-color: #c82333;
        }

        .coupon-form input::placeholder {
            color: #aaa;
            font-style: italic;
        }

    </style>
    <style>
        .shop-services .single-service i {
            font-size: 48px;
            color: #ff4c3b;
        }
        .coupon-form .input-group {
            display: flex;
            align-items: center;
        }
        .cart-summary ul {
            padding: 0;
            list-style: none;
        }
        .cart-summary ul li {
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
        }
        .cart-summary ul li span.label {
            font-weight: bold;
        }
    </style>
@endpush
@push('scripts')
    <script src="{{asset('frontend/js/nice-select/js/jquery.nice-select.min.js')}}"></script>
    <script src="{{ asset('frontend/js/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $("select.select2").select2();
        });
        $('select.nice-select').niceSelect();
    </script>
    <script>
        $(document).ready(function () {
            $('.shipping select[name=shipping]').change(function () {
                let cost = parseFloat($(this).find('option:selected').data('price')) || 0;
                let subtotal = parseFloat($('.order_subtotal').data('price'));
                let coupon = parseFloat($('.coupon_price').data('price')) || 0;
                // alert(coupon);
                $('#order_total_price span').text('$' + (subtotal + cost - coupon).toFixed(2));
            });

        });

    </script>

@endpush
