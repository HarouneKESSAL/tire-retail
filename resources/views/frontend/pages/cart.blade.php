@extends('frontend.layouts.master')
@section('title','Cart Page')
@section('main-content')

    <!-- Shopping Cart -->
    <div class="shopping-cart section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-12">
                    <!-- Shopping Summary -->
                    <table class="table shopping-summary">
                        <thead>
                        <tr class="main-heading">
                            <th style="width: 20%; text-align: center;">PRODUCT</th>
                            <th style="width: 20%; text-align: center;">NAME</th>
                            <th class="text-center" style="width: 15%;">UNIT PRICE</th>
                            <th class="text-center" style="width: 20%;">QUANTITY</th>
                            <th class="text-center" style="width: 15%;">TOTAL</th>
                            <th class="text-center" style="width: 10%;"><i class="ti-trash remove-icon"></i></th>
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
                                        <td class="image" data-title="No" style="text-align: center; vertical-align: middle;">
                                            <img src="{{ $photo[0] }}" alt="{{ $photo[0] }}" style="max-width: 100px; object-fit: contain;">
                                        </td>
                                        <td class="product-des" data-title="Description" style="text-align: center; vertical-align: middle;">
                                            <p class="product-name">
                                                <a href="{{ route('product-detail', $cart->product['slug']) }}" target="_blank">
                                                    {{ $cart->product['title'] }}
                                                </a>
                                            </p>
                                            <p class="product-details">
                                                {{ $cart->product['sku'] }}<br>
                                                {{ $cart->product['size'] }}<br>
                                                Quantité: {{ $cart->quantity }} | Prix: ${{ number_format($cart['price'], 2) }}
                                            </p>
                                            <p class="product-des">{!! $cart['summary'] !!}</p>
                                        </td>
                                        <td class="price" data-title="Price" style="text-align: center; vertical-align: middle;">
                                            <span>${{ number_format($cart['price'], 2) }}</span>
                                        </td>
                                        <td class="qty" data-title="Qty" style="text-align: center; vertical-align: middle;">
                                            <div class="input-group" style="display: flex; align-items: center; justify-content: center;">
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
                                        <td data-title="Total" style="text-align: center; vertical-align: middle;">
                                            <span class="money">${{ number_format($cart['amount'], 2) }}</span>
                                        </td>
                                        <td class="action" data-title="Remove" style="text-align: center; vertical-align: middle;">
                                            <a href="{{ route('cart-delete', $cart->id) }}">
                                                <i class="ti-trash remove-icon"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="6" class="text-right">
                                        <button class="btn-black float-right" type="submit">Update</button>
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td class="text-center" colspan="6">
                                        There are no items in your cart. <a href="{{ route('product-grids') }}" style="color:blue;">Continue shopping</a>
                                    </td>
                                </tr>
                            @endif
                        </form>
                        </tbody>
                    </table>
                    <!--/ End Shopping Summary -->
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <!-- Coupon Input -->
                    <div class="coupon mt-4">
                        <form action="{{ route('coupon-store') }}" method="POST" class="coupon-form">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="code" placeholder="Insérer votre code promo ici" class="form-control mr-2" required>
                                <div class="input-group-append">
                                    <button class="btn btn-danger" type="submit"><i class="fa fa-check"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--/ End Coupon Input -->
                    <!-- Cart Summary -->
                    <div class="cart-summary right mt-4">
                        <ul>
                            @php
                                $cartSubTotal = Helper::totalCartPrice();
                                $shippingFee = 18.00;
                                $tpsTax = $cartSubTotal * 0.05;
                                $tvqTax = $cartSubTotal * 0.0975;
                                $totalAmount = $cartSubTotal + $shippingFee + $tpsTax + $tvqTax;

                                if (session()->has('coupon')) {
                                    $totalAmount -= Session::get('coupon')['value'];
                                }
                            @endphp
                            <li class="subtotal" data-price="{{ $cartSubTotal }}">
                                <span class="label">Sous-Total:</span>
                                <span class="value">${{ number_format($cartSubTotal, 2) }}</span>
                            </li>
                            <li class="shipping-fee">
                                <span class="label">Frais Gouv.:</span>
                                <span class="value">${{ number_format($shippingFee, 2) }}</span>
                            </li>
                            <li class="tax-tps">
                                <span class="label">TPS (5%):</span>
                                <span class="value">${{ number_format($tpsTax, 2) }}</span>
                            </li>
                            <li class="tax-tvq">
                                <span class="label">TVQ (9.975%):</span>
                                <span class="value">${{ number_format($tvqTax, 2) }}</span>
                            </li>
                            <li class="total" id="order_total_price">
                                <span class="label">Total du paiement:</span>
                                <span class="value">${{ number_format($totalAmount, 2) }}</span>
                            </li>
                        </ul>
                        <div class="button">
                            <a href="{{ route('checkout') }}" class="btn-red mt-3">Procéder au paiement</a>
                        </div>
                    </div>
                    <!--/ End Cart Summary -->
                </div>
            </div>
        </div>
    </div>

    <!-- CSS Styling for the Cart Page -->
    @push('styles')
        <style>
            .shopping-cart {
                background-color: #f9f9f9;
                color: #000;
                padding: 30px;
            }

            .shopping-summary {
                background-color: #ffffff;
                border-radius: 10px;
                color: #000;
                width: 100%;
                table-layout: fixed;
            }

            .shopping-summary .main-heading {
                background-color: #f1f1f1;
            }
            
            .cart-summary {
                padding: 20px;
                background-color: #ffffff;
                border-radius: 8px;
                box-shadow: 0px 0px 15px rgba(0,0,0,0.1);
                margin-top: 30px;
            }

            .cart-summary ul li {
                display: flex;
                justify-content: space-between;
                font-weight: bold;
                margin-bottom: 10px;
            }

            .cart-summary .button a {
                width: 100%;
                display: block;
                text-align: center;
            }
            .coupon-form {
                margin-bottom: 20px;
                display: flex;  /* Use flex to align items properly */
                align-items: center; /* Align items vertically in the center */
            }

            .coupon-form .input-group {
                display: flex;
                align-items: center;
                width: 100%;
            }

            .coupon-form input {
                background-color: #f1f1f1;
                color: #000;
                border: 1px solid #ddd;
                padding: 12px;  /* Adjust padding to match the button height */
                border-top-left-radius: 8px;
                border-bottom-left-radius: 8px;
                flex-grow: 1;  /* Make the input take the available space */
            }

            .coupon-form input:focus {
                outline: none;
            }

            .coupon-form .input-group-append .btn {
                background-color: #c30000;
                border: none;
                border-top-right-radius: 8px;
                border-bottom-right-radius: 8px;
                padding: 12px 20px;  /* Adjust padding to align properly with the input */
                height: 100%;
                line-height: 1.5; /* Ensure vertical alignment */
            }

            .coupon-form .input-group-append .btn:hover {
                background-color: #a80000;
            }

            .input-group {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .input-group .btn-number {
                padding: 5px 10px;
                font-size: 16px;
            }

            .input-number {
                width: 50px;
                text-align: center;
            }

            .image img {
                margin: 0 auto;
                display: block;
            }
        </style>
    @endpush

@endsection
