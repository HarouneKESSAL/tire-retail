@extends('frontend.layouts.master')

@section('title','E-SHOP || PRODUCT PAGE')

@section('main-content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li>Home<i class="ti-arrow-right"></i></li>
                            <li class="active">Shop Grid</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Product Style -->
    <form action="{{ route('shop.filter') }}" method="POST">
        @csrf
        <!-- Hidden input fields to retain filters -->
        <input type="hidden" name="car_brand" value="{{ request('car_brand') }}">
        <input type="hidden" name="model" value="{{ request('model') }}">
        <input type="hidden" name="year" value="{{ request('year') }}">
        <input type="hidden" name="width" value="{{ request('width') }}">
        <input type="hidden" name="aspect_ratio" value="{{ request('aspect_ratio') }}">
        <input type="hidden" name="diameter" value="{{ request('diameter') }}">

        <section class="product-area shop-sidebar shop section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="shop-sidebar">

                            <!-- Car Name -->
                            <div class="single-widget">
                                <h3 class="title">{{ $carName }}</h3>
                            </div>

                            <!-- Categories -->
                            <div class="single-widget category">
                                <h3 class="title">Categories</h3>
                                <ul class="categor-list">
                                    @if($menu)
                                        @foreach($menu as $cat_info)
                                            <li>
                                                <a href="{{ route('product-cat', $cat_info->slug) }}">{{ $cat_info->title }}</a>
                                                @if($cat_info->child_cat->count() > 0)
                                                    <ul>
                                                        @foreach($cat_info->child_cat as $sub_menu)
                                                            <li><a href="{{ route('product-sub-cat', [$cat_info->slug, $sub_menu->slug]) }}">{{ $sub_menu->title }}</a></li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <!-- Price Filter -->
                            <div class="single-widget range">
                                <h3 class="title">Shop by Price</h3>
                                <div class="price-filter">
                                    <div class="price-filter-inner">
                                        @php
                                            $max = DB::table('products')->max('price');
                                        @endphp
                                        <div id="slider-range" data-min="0" data-max="{{ $max }}"></div>
                                        <div class="product_filter">
                                            <button type="submit" class="filter-btn">Filter</button>
                                            <div class="label-input">
                                                <span>Range:</span>
                                                <input style="" type="text" id="amount" readonly/>
                                                <input type="hidden" name="price" id="price_range" value="{{ request('price') }}"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Filter Options -->
                            <div class="single-widget category options">
                                <h3 class="title" data-toggle="collapse" data-target="#filterOptions" aria-expanded="false" aria-controls="filterOptions">
                                    FILTRE DE RECHERCHE <i class="fa fa-angle-down"></i>
                                </h3>
                                <div id="filterOptions" class="collapse">
                                    <ul class="categor-list">
                                        <!-- Dynamic filters -->
                                        @foreach(['vitesse', 'lettrage', 'charge'] as $option)
                                            <li class="form-group row">
                                                <label for="{{ $option }}" class="col-sm-4 col-form-label">{{ ucfirst($option) }}</label>
                                                <div class="col-sm-8">
                                                    <select name="options[{{ $option }}]" id="{{ $option }}" class="form-control">
                                                        <option value="">Optional</option>
                                                        @foreach(${$option.'s'} as $option_value)
                                                            <option value="{{ $option_value->value }}">{{ $option_value->value }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </li>
                                        @endforeach

                                        <!-- Checkbox filters -->
                                        @foreach(['runflat' => 'Runflat', 'xl_renforces' => 'XL / Renforcés', 'cloutable' => 'Cloutable', 'choix_equipe' => 'Choix de l\'équipe', 'en_solde' => 'En Solde'] as $key => $label)
                                            <li class="form-group">
                                                <label for="{{ $key }}">{{ $label }}</label>
                                                <input type="checkbox" name="options[{{ $key }}]" id="{{ $key }}" value="1" @if(request()->has("options.$key")) checked @endif>
                                                {{ $label }} ({{ $$key }})
                                            </li>
                                        @endforeach

                                        <!-- Filter Button -->
                                        <li class="form-group">
                                            <button type="submit" class="filter-btn">Filter</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Recent Posts -->
                            <div class="single-widget recent-post">
                                <h3 class="title">Recent post</h3>
                                @foreach($recent_products as $product)
                                    @php
                                        $photo = explode(',', $product->photo);
                                    @endphp
                                    <div class="single-post first">
                                        <div class="image">
                                            <img src="{{ $photo[0] }}" alt="{{ $product->title }}">
                                        </div>
                                        <div class="content">
                                            <h5><a href="{{ route('product-detail', $product->slug) }}">{{ $product->title }}</a></h5>
                                            <p class="price">
                                                <del class="text-muted">${{ number_format($product->price, 2) }}</del>
                                                ${{ number_format(($product->price - ($product->price * $product->discount) / 100), 2) }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Brands -->
                            <div class="single-widget category">
                                <h3 class="title">Brands</h3>
                                <ul class="categor-list">
                                    @foreach($brands as $brand)
                                        <li><a href="{{ route('product-brand', $brand->slug) }}">{{ $brand->car_brand }} {{ $brand->car_model }} {{ $brand->car_year }}</a></li>
                                    @endforeach
                                </ul>
                            </div>

                        </div>
                    </div>

                    <!-- Main Product Area -->
                    <div class="col-lg-9 col-md-8 col-12">
                        <div class="row">
                            <div class="col-12">
                                <div class="shop-top">
                                    <div class="shop-shorter">
                                        <div class="single-shorter">
                                            <label>Show :</label>
                                            <select class="show" name="show" onchange="this.form.submit();">
                                                <option value="">Default</option>
                                                @foreach([9, 15, 21, 30] as $show)
                                                    <option value="{{ $show }}" @if(request('show') == $show) selected @endif>{{ $show }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="single-shorter">
                                            <label>Sort By :</label>
                                            <select class='sortBy' name='sortBy' onchange="this.form.submit();">
                                                <option value="">Default</option>
                                                @foreach(['price', 'category', 'brand'] as $sortBy)
                                                    <option value="{{ $sortBy }}" @if(request('sortBy') == $sortBy) selected @endif>{{ ucfirst($sortBy) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <ul class="view-mode">
                                        <li class="active"><a href="javascript:void(0)"><i class="fa fa-th-large"></i></a></li>
                                        <li><a href="{{ route('product-lists') }}"><i class="fa fa-th-list"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @if(count($products) > 0)
                                @foreach($products as $product)
                                    <div class="col-lg-4 col-md-6 col-12">
                                        <div class="single-product">
                                            <div class="product-img">
                                                <a href="{{ route('product-detail', $product->slug) }}">
                                                    @php
                                                        $photo = explode(',', $product->photo);
                                                    @endphp
                                                    <img class="default-img" src="{{ $photo[0] }}" alt="{{ $product->title }}">
                                                    <img class="hover-img" src="{{ $photo[0] }}" alt="{{ $product->title }}">
                                                    @if($product->discount)
                                                        <span class="price-dec">{{ $product->discount }}% Off</span>
                                                    @endif
                                                </a>
                                                <div class="button-head">
                                                    <div class="product-action">
                                                        <a data-toggle="modal" data-target="#product-{{ $product->id }}" title="Quick View" href="#"><i class="ti-eye"></i><span>Quick Shop</span></a>
                                                        <a title="Wishlist" href="{{ route('add-to-wishlist', $product->slug) }}" class="wishlist" data-id="{{ $product->id }}"><i class="ti-heart "></i><span>Add to Wishlist</span></a>
                                                    </div>
                                                    <div class="product-action-2">
                                                        <a title="Add to cart" href="{{ route('add-to-cart', $product->slug) }}">Add to cart</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <h3><a href="{{ route('product-detail', $product->slug) }}">{{ $product->title }}</a></h3>
                                                @php
                                                    $after_discount = $product->price - ($product->price * $product->discount) / 100;
                                                @endphp
                                                <span>${{ number_format($after_discount, 2) }}</span>
                                                <del style="padding-left:4%;">${{ number_format($product->price, 2) }}</del>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <h4 class="text-danger" style="margin:100px auto;">There are no products.</h4>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-12 justify-content-center d-flex">
                                {{ $products->appends(request()->input())->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
    <!--/ End Product Style 1  -->

    <!-- Modal -->
    @if($products)
        @foreach($products as $product)
            <div class="modal fade" id="product-{{ $product->id }}" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="ti-close" aria-hidden="true"></span></button>
                        </div>
                        <div class="modal-body">
                            <div class="row no-gutters">
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <!-- Product Slider -->
                                    <div class="product-gallery">
                                        <div class="quickview-slider-active">
                                            @foreach(explode(',', $product->photo) as $data)
                                                <div class="single-slider">
                                                    <img src="{{ $data }}" alt="{{ $product->title }}">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <!-- End Product slider -->
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <div class="quickview-content">
                                        <h2>{{ $product->title }}</h2>
                                        <div class="quickview-ratting-review">
                                            <div class="quickview-ratting-wrap">
                                                <div class="quickview-ratting">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($rate >= $i)
                                                            <i class="yellow fa fa-star"></i>
                                                        @else
                                                            <i class="fa fa-star"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <a href="#">({{ $rate_count }} customer review)</a>
                                            </div>
                                            <div class="quickview-stock">
                                                @if($product->stock > 0)
                                                    <span><i class="fa fa-check-circle-o"></i> {{ $product->stock }} in stock</span>
                                                @else
                                                    <span><i class="fa fa-times-circle-o text-danger"></i> Out of stock</span>
                                                @endif
                                            </div>
                                        </div>
                                        <h3><small><del class="text-muted">${{ number_format($product->price, 2) }}</del></small> ${{ number_format($after_discount, 2) }}</h3>
                                        <div class="quickview-peragraph">
                                            <p>{!! html_entity_decode($product->summary) !!}</p>
                                        </div>
                                        @if($product->size)
                                            <div class="size">
                                                <h4>Size</h4>
                                                <ul>
                                                    @foreach(explode(',', $product->size) as $size)
                                                        <li><a href="#" class="one">{{ $size }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <div class="add-to-cart">
                                            <form action="{{ route('single-add-to-cart') }}" method="POST">
                                                @csrf
                                                <div class="quantity">
                                                    <div class="input-group">
                                                        <div class="button minus">
                                                            <button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
                                                                <i class="ti-minus"></i>
                                                            </button>
                                                        </div>
                                                        <input type="hidden" name="slug" value="{{ $product->slug }}">
                                                        <input type="text" name="quant[1]" class="input-number" data-min="1" data-max="1000" value="1">
                                                        <div class="button plus">
                                                            <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[1]">
                                                                <i class="ti-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn">Add to cart</button>
                                            </form>
                                            <a href="{{ route('add-to-wishlist', $product->slug) }}" class="btn min"><i class="ti-heart"></i></a>
                                        </div>
                                        <div class="default-social">
                                            <div class="sharethis-inline-share-buttons"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
    <!-- Modal end -->
@endsection

@push('styles')
    <style>
        .pagination {
            display: inline-flex;
        }

        .filter-btn {
            margin: 0 5px;
            padding: 10px 20px;
            background-color: #ff0000; /* Red color */
            color: white;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease, transform 0.3s ease; /* Smooth transition */
        }

        .filter-btn.active {
            background-color: #ff0000; /* Active button should be red */
            color: white; /* Text color should be white */
        }
        .filter-btn:hover {
            background-color: #b30000; /* Darker red on active/hover */
            color: #fff;
            transform: scale(1.05); /* Slightly enlarge the button on hover */
        }

        form li {
            list-style-type: none;
            margin-bottom: 15px;
        }

        form li label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        form .form-control {
            width: 100%;
            padding: 8px;
            margin-bottom: 5px;
        }

        form li input[type="checkbox"] {
            margin-right: 10px;
        }

        form li label input[type="checkbox"] {
            display: inline-block;
            margin-top: 3px;
        }

        .options {
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .options h4 {
            margin-bottom: 15px;
            font-size: 18px;
            color: #333;
        }

        .options select {
            width: 100%;
            padding: 8px;
            margin-bottom: 5px;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script>
        $(document).ready(function () {
            /*----------------------------------------------------*/
            /*  Jquery Ui slider js
            /*----------------------------------------------------*/
            if ($("#slider-range").length > 0) {
                const max_value = parseInt($("#slider-range").data('max')) || 500;
                const min_value = parseInt($("#slider-range").data('min')) || 0;
                const currency = $("#slider-range").data('currency') || '';
                let price_range = min_value + '-' + max_value;
                if ($("#price_range").length > 0 && $("#price_range").val()) {
                    price_range = $("#price_range").val().trim();
                }

                let price = price_range.split('-');
                $("#slider-range").slider({
                    range: true,
                    min: min_value,
                    max: max_value,
                    values: price,
                    slide: function (event, ui) {
                        $("#amount").val(currency + ui.values[0] + " -  " + currency + ui.values[1]);
                        $("#price_range").val(ui.values[0] + "-" + ui.values[1]);
                    }
                });
            }
            if ($("#amount").length > 0) {
                const m_currency = $("#slider-range").data('currency') || '';
                $("#amount").val(m_currency + $("#slider-range").slider("values", 0) +
                    "  -  " + m_currency + $("#slider-range").slider("values", 1));
            }
        })
    </script>
@endpush