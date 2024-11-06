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
                            <li>{{ __('Accueil') }}<i class="ti-arrow-right"></i></li>
                            <li class="active">{{ __('Boutique en Grille') }}</li>
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
        <input type="hidden" name="viewType" value="grid">
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
                            <div class="single-widget category">
                                <h3 class="title">Categories</h3>
                                <ul class="categor-list">
                                    @php
                                        $menu=App\Models\Category::getAllParentWithChild();
                                    @endphp
                                    @if($menu)
                                        <li>
                                        @foreach($menu as $cat_info)
                                            @if($cat_info->child_cat->count()>0)
                                                <li><a href="{{route('product-cat',$cat_info->slug)}}">{{$cat_info->title}}</a>
                                                    <ul>
                                                        @foreach($cat_info->child_cat as $sub_menu)
                                                            <li><a href="{{route('product-sub-cat',[$cat_info->slug,$sub_menu->slug])}}">{{$sub_menu->title}}</a></li>
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @else
                                                <li><a href="{{route('product-cat',$cat_info->slug)}}">{{$cat_info->title}}</a></li>
                                                @endif
                                                @endforeach
                                                </li>
                                            @endif
                                </ul>
                            </div>
                            <!--/ End Single Widget -->
                            <div class="filter-sidebar">
                                <!-- Search Filter Title -->
                                <h3 class="filter-title">{{ __('Filtre de Recherche') }}</h3>
                                <!-- Filter Sections -->
                                <div class="filter-section">
                                    <!-- Options Section -->
                                    <div class="single-widget options">
                                        <h4 class="filter-subtitle" data-toggle="collapse" data-target="#filterOptions" aria-expanded="false" aria-controls="filterOptions">
                                            OPTIONS <i class="fa fa-angle-down"></i>
                                        </h4>
                                        <div id="filterOptions" class="collapse show">
                                            <ul class="filter-list">
                                                <!-- Season -->
                                                <li class="form-group row">
                                                    <label for="season" class="col-sm-5 col-form-label">Saison</label>
                                                    <div class="col-sm-7">
                                                        <select name="season" id="season" class="form-control custom-select">
                                                            <option value="">Hiver</option>
                                                        </select>
                                                    </div>
                                                </li>

                                                <!-- Speed Index -->
                                                <li class="form-group row">
                                                    <label for="speed_index" class="col-sm-5 col-form-label">Indice de vitesse</label>
                                                    <div class="col-sm-7">
                                                        <select name="options[speed_index]" id="speed_index" class="form-control custom-select">
                                                            <option value="">Optionnel</option>
                                                            @foreach($speed_indexes as $speed_index)
                                                                <option value="{{ $speed_index }}">{{ $speed_index }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </li>

                                                <!-- Load Index -->
                                                <li class="form-group row">
                                                    <label for="load_index" class="col-sm-5 col-form-label">Indice de charge</label>
                                                    <div class="col-sm-7">
                                                        <select name="options[load_index]" id="load_index" class="form-control custom-select">
                                                            <option value="">Optionnel</option>
                                                            @foreach($load_indexes as $load_index)
                                                                <option value="{{ $load_index }}">{{ $load_index }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </li>

                                                <!-- Service Type -->
                                                <li class="form-group row">
                                                    <label for="service_type" class="col-sm-5 col-form-label">Type de service</label>
                                                    <div class="col-sm-7">
                                                        <select name="options[service_type]" id="service_type" class="form-control custom-select">
                                                            <option value="">Optionnel</option>
                                                            @foreach($service_types as $service_type)
                                                                <option value="{{ $service_type }}">{{ $service_type }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </li>

                                                <!-- Shipping Weight -->
                                                <li class="form-group row">
                                                    <label for="shipping_weight" class="col-sm-5 col-form-label">Poids d'expédition</label>
                                                    <div class="col-sm-7">
                                                        <select name="options[shipping_weight]" id="shipping_weight" class="form-control custom-select">
                                                            <option value="">Optionnel</option>
                                                            @foreach($shipping_weights as $shipping_weight)
                                                                <option value="{{ $shipping_weight }}">{{ $shipping_weight }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </li>

                                                <!-- Boolean Filters -->
                                                <li class="form-group">
                                                    <label>
                                                        <input type="checkbox" name="options[available_only]" id="available_only" value="1"> Disponible seulement
                                                    </label>
                                                </li>
                                                <li class="form-group">
                                                    <label>
                                                        <input type="checkbox" name="options[runflat]" id="runflat" value="1"> Runflat
                                                    </label>
                                                </li>
                                                <li class="form-group">
                                                    <label>
                                                        <input type="checkbox" name="options[xl_renforces]" id="xl_renforces" value="1"> XL / Renforcés
                                                    </label>
                                                </li>
                                                <li class="form-group">
                                                    <label>
                                                        <input type="checkbox" name="options[cloutable]" id="cloutable" value="1"> Cloutable
                                                    </label>
                                                </li>
                                                <li class="form-group">
                                                    <label>
                                                        <input type="checkbox" name="options[team_choice]" id="team_choice" value="1"> Choix de l'équipe
                                                    </label>
                                                </li>
                                                <li class="form-group">
                                                    <label>
                                                        <input type="checkbox" name="options[on_sale]" id="on_sale" value="1"> En solde / En liquidation
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- Price Filter -->
                                    <!-- Price Filter -->
                                    <div class="single-widget range">
                                        <h4 class="filter-subtitle" data-toggle="collapse" data-target="#priceFilter" aria-expanded="false" aria-controls="priceFilter">
                                            PRIX <i class="fa fa-angle-down"></i>
                                        </h4>
                                        <div id="priceFilter" class="collapse show">
                                            <ul class="categor-list">
                                                <li class="form-group row">
                                                    <label for="price_range" class="col-sm-4 col-form-label">Prix</label>
                                                    <div class="col-sm-8">
                                                        <select name="price_range" id="price_range" class="form-control custom-select">
                                                            <option value="0-50">0-50$</option>
                                                            <option value="50-100">50-100$</option>
                                                            <option value="100-150">100-150$</option>
                                                            <option value="150+">150$ et +</option>
                                                        </select>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- Filter Button -->
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-filter">FILTRER MA RECHERCHE</button>
                                    </div>
                                </div>
                            </div>
                            <style>
                                /* Ensure full width for the filter list */
                                .single-widget.range .categor-list {
                                    width: 100%;
                                }

                                /* Consistent styling for the select element */
                                .single-widget.range .form-control.custom-select {
                                    width: 100%;
                                    height: 42px; /* Match the height with other dropdowns */
                                    padding: 10px;
                                    font-size: 14px; /* Ensure consistent font size */
                                    border-radius: 5px;
                                    border: 1px solid #ccc;
                                    background-color: #fff;
                                }

                                /* Consistent styling for form-group elements */
                                .single-widget.range .form-group.row {
                                    margin-bottom: 15px;
                                    align-items: center; /* Ensure label and select are vertically aligned */
                                }

                                .single-widget.range .col-sm-4 {
                                    font-size: 14px;
                                    padding-top: 5px;
                                }

                                .single-widget.range .col-sm-8 {
                                    padding-left: 0;
                                }

                                .single-widget.range {
                                    padding: 15px;
                                    background-color: #f9f9f9; /* Keep background consistent */
                                    border-radius: 5px;
                                }

                                .single-widget.range .filter-subtitle {
                                    font-size: 16px;
                                    font-weight: bold;
                                    margin-bottom: 10px;
                                }


                            </style>
                            <style>
                                .single-widget.range .filter-list li .form-control.custom-select {
                                    width: 100%; /* Ensure full width */
                                    padding: 8px;
                                    border-radius: 5px;
                                    border: 1px solid #ccc;
                                    background-color: #fff; /* Ensure the dropdown background is white */
                                    box-sizing: border-box; /* Fix the padding and margin for width */
                                    display: block; /* Make sure it expands fully */
                                }

                                .single-widget.range .filter-list {
                                    display: block; /* Make sure the list inside the price filter behaves like block elements */
                                    margin: 0;
                                    padding: 0;
                                    width: 100%; /* Ensure the width of the filter list takes up the full available space */
                                }

                                .single-widget.range {
                                    padding: 10px;
                                    background-color: #f5f5f5;
                                    border-radius: 5px;
                                }

                                .filter-list li select {
                                    width: 100%; /* Make sure the select element takes up the full width */
                                    margin-top: 10px;
                                }

                                .filter-sidebar {
                                    background-color: #fff;
                                    padding: 20px;
                                    border-radius: 8px;
                                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                                }

                                .filter-title {
                                    font-size: 18px;
                                    font-weight: bold;
                                    margin-bottom: 20px;
                                    text-transform: uppercase;
                                    color: #333;
                                }

                                .single-widget {
                                    margin-bottom: 30px;
                                }

                                .filter-subtitle {
                                    font-size: 16px;
                                    font-weight: bold;
                                    text-transform: uppercase;
                                    color: #333;
                                    cursor: pointer;
                                    display: flex;
                                    justify-content: space-between;
                                    align-items: center;
                                }

                                .filter-list {
                                    list-style-type: none;
                                    padding: 0;
                                }

                                .filter-list li {
                                    margin-bottom: 15px;
                                }

                                .filter-list li label {
                                    font-size: 14px;
                                    color: #333;
                                }

                                .form-control.custom-select {
                                    width: 100%;
                                    padding: 10px;
                                    border-radius: 5px;
                                    border: 1px solid #ccc;
                                    background-color: #f5f5f5;
                                    color: #333;
                                }

                                .btn-filter {
                                    background-color: #ff0000;
                                    color: #fff;
                                    padding: 10px 20px;
                                    width: 100%;
                                    border: none;
                                    border-radius: 5px;
                                    cursor: pointer;
                                    transition: all 0.3s ease;
                                }

                                .btn-filter:hover {
                                    background-color: #b30000;
                                }

                            </style>

                        </div>
                    </div>

                    <!-- Main Product Area -->
                    <div class="col-lg-9 col-md-8 col-12">
                        <div class="row">
                            <div class="col-12">
                                <!-- Shop Top -->
                                <div class="shop-top">
                                    <div class="shop-shorter">
                                        <div class="single-shorter">
                                            <label>Show :</label>
                                            <select class="show" name="show" onchange="this.form.submit();">
                                                <option value="">Default</option>
                                                <option value="9" @if(!empty($_GET['show']) && $_GET['show']=='9') selected @endif>09</option>
                                                <option value="15" @if(!empty($_GET['show']) && $_GET['show']=='15') selected @endif>15</option>
                                                <option value="21" @if(!empty($_GET['show']) && $_GET['show']=='21') selected @endif>21</option>
                                                <option value="30" @if(!empty($_GET['show']) && $_GET['show']=='30') selected @endif>30</option>
                                            </select>
                                        </div>
                                        <div class="single-shorter">
                                            <label>Sort By :</label>
                                            <select class='sortBy' name='sortBy' onchange="this.form.submit();">
                                                <option value="">Default</option>
                                                <option value="title" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='title') selected @endif>Name</option>
                                                <option value="price" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='price') selected @endif>Price</option>
                                                <option value="category" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='category') selected @endif>Category</option>
                                                <option value="brand" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='brand') selected @endif>Brand</option>
                                            </select>
                                        </div>
                                    </div>
                                    <ul class="view-mode">
                                        <li class="active"><a href="{{ route('product.view', ['viewType' => 'grid']) }}"><i class="fa fa-th-large"></i></a></li>
                                        <li><a href="{{ route('product.view', ['viewType' => 'list']) }}"><i class="fa fa-th-list"></i></a></li>
                                    </ul>
                                </div>
                                <!--/ End Shop Top -->
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
                                                    <img class="default-img" src="{{ $photo[0] }}"
                                                         alt="{{ $product->title }}">
                                                    <img class="hover-img" src="{{ $photo[0] }}"
                                                         alt="{{ $product->title }}">
                                                    @if($product->discount)
                                                        <span class="price-dec">{{ $product->discount }}% Off</span>
                                                    @endif
                                                </a>
                                                <div class="button-head">
                                                    <div class="product-action">
                                                        <a data-toggle="modal" data-target="#product-{{ $product->id }}"
                                                           title="Quick View" href="#"><i class="ti-eye"></i><span>Quick Shop</span></a>
                                                        <a title="Wishlist"
                                                           href="{{ route('add-to-wishlist', $product->slug) }}"
                                                           class="wishlist" data-id="{{ $product->id }}"><i
                                                                class="ti-heart "></i><span>Add to Wishlist</span></a>
                                                    </div>
                                                    <div class="product-action-2">
                                                        <a title="Add to cart"
                                                           href="{{ route('add-to-cart', $product->slug) }}">Add to
                                                            cart</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <h3>
                                                    <a  href="{{ route('product-detail', $product->slug) }}">{{ $product->title }}</a>
                                                </h3>
                                                @php
                                                    $after_discount = $product->price - ($product->price * $product->discount) / 100;
                                                @endphp
                                                <span>${{ number_format($after_discount, 2) }}</span>
                                                <del style="padding-left:4%;">
                                                    ${{ number_format($product->price, 2) }}</del>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <h4 class="text-danger" style="margin:100px auto;">There are no products.</h4>
                            @endif
                        </div>
                        <br><br>
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
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    class="ti-close" aria-hidden="true"></span></button>
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
                                                    @php
                                                        $rate=DB::table('product_reviews')->where('product_id',$product->id)->avg('rate');
                                                        $rate_count=DB::table('product_reviews')->where('product_id',$product->id)->count();
                                                    @endphp
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
                                        <h3><small>
                                                <del class="text-muted">${{ number_format($product->price, 2) }}</del>
                                            </small> ${{ number_format($after_discount, 2) }}</h3>
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
                                                            <button type="button" class="btn btn-primary btn-number"
                                                                    disabled="disabled" data-type="minus"
                                                                    data-field="quant[1]">
                                                                <i class="ti-minus"></i>
                                                            </button>
                                                        </div>
                                                        <input type="hidden" name="slug" value="{{ $product->slug }}">
                                                        <input type="text" name="quant[1]" class="input-number"
                                                               data-min="1" data-max="1000" value="1">
                                                        <div class="button plus">
                                                            <button type="button" class="btn btn-primary btn-number"
                                                                    data-type="plus" data-field="quant[1]">
                                                                <i class="ti-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn">Add to cart</button>
                                            </form>
                                            <a href="{{ route('add-to-wishlist', $product->slug) }}" class="btn min"><i
                                                    class="ti-heart"></i></a>
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
            margin: 10px 5px;
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
