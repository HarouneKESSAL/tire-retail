@extends('frontend.layouts.master')

@section('title','E-SHOP || HOME PAGE')

@section('main-content')


    <div class="filter-box">
        <div class="filter-options text-center mb-4">
            <button type="button" id="pneu-btn" class="filter-btn active">Pneu</button>
            <button type="button" id="pneu-jantes-btn" class="filter-btn">Pneu/Jantes</button>
            <button type="button" id="roues-jantes-btn" class="filter-btn">Roues/Jantes</button>
        </div>

        <!-- PNEU Form -->
        <div id="pneu-filter" class="filter-content active">
            <form id="pneu-form" method="POST" action="{{ route('product.search') }}" class="filter-form">
                @csrf
                <input type="hidden" name="category_slug" value="pneu">
                <div class="form-row mb-3">
                    <div class="col">
                        <select name="width" class="form-control">
                            <option value="">Largeur</option>
                            @foreach($pneuDimensions['widths'] as $width)
                                <option value="{{ $width->width }}">{{ $width->width }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <select name="aspect_ratio" class="form-control">
                            <option value="">Rapport</option>
                            @foreach($pneuDimensions['aspect_ratios'] as $aspect_ratio)
                                <option value="{{ $aspect_ratio->aspect_ratio }}">{{ $aspect_ratio->aspect_ratio }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <select name="diameter" class="form-control">
                            <option value="">Diametre</option>
                            @foreach($pneuDimensions['diameters'] as $diameter)
                                <option value="{{ $diameter->diameter }}">{{ $diameter->diameter }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row mb-3">
                    <div class="col">
                        <label><input type="checkbox" name="season[]" value="summer"> Summer</label>
                    </div>
                    <div class="col">
                        <label><input type="checkbox" name="season[]" value="winter"> Winter</label>
                    </div>
                    <div class="col">
                        <label><input type="checkbox" name="season[]" value="all-season"> All Season</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-black btn-block">Lancer la recherche</button>
            </form>
        </div>

        <!-- PNEU/JANTES Form -->
        <div id="pneu-jantes-filter" class="filter-content">
            <form id="pneu-jantes-form" method="post" action="{{ route('filter.results') }}" class="filter-form">
                @csrf
                <input type="hidden" name="category_slug" value="pneujantes">
                <div class="form-row mb-3">
                    <div class="col">
                        <select name="year" class="form-control">
                            <option value="">Select Year</option>
                            @foreach($years as $year)
                                <option value="{{ $year->car_year }}">{{ $year->car_year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <select name="car_brand" class="form-control">
                            <option value="">Select Make</option>
                            @foreach($car_brands as $car_brand)
                                <option value="{{ $car_brand->car_brand }}">{{ $car_brand->car_brand }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row mb-3">
                    <div class="col">
                        <select name="model" class="form-control">
                            <option value="">Select Model</option>
                            @foreach($models as $model)
                                <option value="{{ $model->car_model }}">{{ $model->car_model }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <select name="option" class="form-control mb-2">
                            <option value="">Select Option</option>
                            @foreach($options as $option)
                                <option value="{{ $option->name }}">{{ $option->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row mb-3">
                    <div class="col">
                        <label><input type="checkbox" name="season[]" value="summer"> Summer</label>
                    </div>
                    <div class="col">
                        <label><input type="checkbox" name="season[]" value="winter"> Winter</label>
                    </div>
                    <div class="col">
                        <label><input type="checkbox" name="season[]" value="all-season"> All Season</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-black btn-block">Lancer la recherche</button>
            </form>
        </div>

        <!-- ROUES/JANTES Form -->
        <div id="roues-jantes-filter" class="filter-content">
            <form id="roues-jantes-form" method="GET" action="{{ route('filter.results') }}" class="filter-form">
                @csrf
                <input type="hidden" name="category_slug" value="rouesjantes">
                <div class="form-row mb-3">
                    <div class="col">
                        <select name="width" class="form-control">
                            <option value="">Largeur</option>
                            @foreach($rouesJantesDimensions['widths'] as $width)
                                <option value="{{ $width->width }}">{{ $width->width }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <select name="aspect_ratio" class="form-control">
                            <option value="">Rapport</option>
                            @foreach($rouesJantesDimensions['aspect_ratios'] as $aspect_ratio)
                                <option value="{{ $aspect_ratio->aspect_ratio }}">{{ $aspect_ratio->aspect_ratio }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <select name="diameter" class="form-control">
                            <option value="">Diametre</option>
                            @foreach($rouesJantesDimensions['diameters'] as $diameter)
                                <option value="{{ $diameter->diameter }}">{{ $diameter->diameter }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-row mb-3">
                    <div class="col">
                        <label><input type="checkbox" name="season[]" value="summer"> Summer</label>
                    </div>
                    <div class="col">
                        <label><input type="checkbox" name="season[]" value="winter"> Winter</label>
                    </div>
                    <div class="col">
                        <label><input type="checkbox" name="season[]" value="all-season"> All Season</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-black btn-block">Lancer la recherche</button>
            </form>
        </div>
    </div>


    <!-- Filter Section End -->

    <!-- Modal for Displaying Filter Result -->
    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Filter Results</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="filterResults">
                    <!-- Search results will be displayed here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal End --><!-- Filter Section End -->

    <!-- Modal for Displaying Filter Result -->
    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Filter Results</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="filterResults">
                    <!-- Search results will be displayed here -->
                </div>
            </div>
        </div>
    </div>
    <!-- Modal End -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterBtns = document.querySelectorAll('.filter-btn');
            const filterContents = document.querySelectorAll('.filter-content');
            const filterForms = document.querySelectorAll('.filter-form');
            const filterModal = new bootstrap.Modal(document.getElementById('filterModal'));

            filterBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    filterBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    const targetId = this.id.replace('-btn', '-filter');
                    filterContents.forEach(content => {
                        content.classList.remove('active');
                        if (content.id === targetId) {
                            content.classList.add('active');
                        }
                    });
                });
            });

            filterForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const formData = new FormData(this);
                    fetch(this.action, {
                        method: this.method,
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                        .then(response => response.text())
                        .then(data => {
                            document.getElementById('filterResults').innerHTML = data;
                            filterModal.show();
                        })
                        .catch(error => console.error('Error:', error));
                });
            });
        });
    </script>
    <!-- Slider Area -->
    @if(count($banners) > 0)
        <section id="Gslider" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                @foreach($banners as $key => $banner)
                    <li data-target="#Gslider" data-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}"></li>
                @endforeach
            </ol>
            <div class="carousel-inner" role="listbox">
                @foreach($banners as $key => $banner)
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                        <img class="first-slide" src="{{ $banner->photo }}" alt="First slide">
                        <div class="carousel-caption d-none d-md-block text-left">
                            <h1 class="wow fadeInDown">{{ $banner->title }}</h1>
                            <p>{!! html_entity_decode($banner->description) !!}</p>
                            <a class="btn  btn-lg ws-btn wow fadeInUpBig" href="{{ route('product-grids') }}"
                               role="button">Shop Now<i class="far fa-arrow-alt-circle-right"></i></a>
                        </div>
                    </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#Gslider" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#Gslider" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </section>
    @endif

    <!-- Start Small Banner  -->
    <section class="small-banner section">
        <div class="container-fluid">
            <div class="row">
                @php
                    $category_lists=DB::table('categories')->where('status','active')->limit(3)->get();
                @endphp
                @if($category_lists)
                    @foreach($category_lists as $cat)
                        @if($cat->is_parent==1)
                            <!-- Single Banner  -->
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="single-banner">
                                    @if($cat->photo)
                                        <img src="{{$cat->photo}}" alt="{{$cat->photo}}">
                                    @else
                                        <img src="https://via.placeholder.com/600x370" alt="#">
                                    @endif
                                    <div class="content">
                                        <h3>{{$cat->title}}</h3>
                                        <a href="{{route('product-cat',$cat->slug)}}">Discover Now</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <!-- /End Single Banner  -->
                    @endforeach
                @endif
            </div>
        </div>
    </section>
    <!-- End Small Banner -->

    <!-- Start Product Area -->
    <div class="product-area section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Trending Item</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="product-info">
                        <div class="nav-main">
                            <!-- Tab Nav -->
                            <ul class="nav nav-tabs filter-tope-group" id="myTab" role="tablist">
                                @php
                                    $categories = DB::table('categories')
                                        ->where('status', 'active')
                                        ->where('is_parent', 1)
                                        ->get();
                                @endphp
                                @if($categories)
                                    <button class="btn btn-category active" data-filter="*">
                                        All Products
                                    </button>
                                    @foreach($categories as $key => $cat)
                                        <button class="btn btn-category" data-filter=".{{$cat->id}}">
                                            {{$cat->title}}
                                        </button>
                                    @endforeach
                                @endif
                            </ul>
                            <!--/ End Tab Nav -->
                        </div>
                        <div class="tab-content isotope-grid" id="myTabContent">
                            <!-- Start Single Tab -->
                            @if($product_lists)
                                @foreach($product_lists as $key => $product)
                                    <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item {{$product->cat_id}}">
                                        <div class="single-product">
                                            <div class="product-img">
                                                <a href="{{route('product-detail', $product->slug)}}">
                                                    @php
                                                        $photo = explode(',', $product->photo);
                                                    @endphp
                                                    <img class="default-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                                    <img class="hover-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                                    @if($product->stock <= 0)
                                                        <span class="out-of-stock">Sale out</span>
                                                    @elseif($product->condition == 'new')
                                                        <span class="new">New</span>
                                                    @elseif($product->condition == 'hot')
                                                        <span class="hot">Hot</span>
                                                    @else
                                                        <span class="price-dec">{{$product->discount}}% Off</span>
                                                    @endif
                                                </a>
                                                <div class="button-head">
                                                    <div class="product-action">
                                                        <a data-toggle="modal" data-target="#{{$product->id}}"
                                                           title="Quick View" href="#"><i class="ti-eye"></i><span>Quick Shop</span></a>
                                                        <a title="Wishlist" href="{{route('add-to-wishlist', $product->slug)}}"><i
                                                                class="ti-heart"></i><span>Add to Wishlist</span></a>
                                                    </div>
                                                    <div class="product-action-2">
                                                        <a title="Add to cart"
                                                           href="{{route('add-to-cart', $product->slug)}}">Add to
                                                            cart</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <h3>
                                                    <a href="{{route('product-detail', $product->slug)}}">{{$product->title}}</a>
                                                </h3>
                                                <div class="product-price">
                                                    @php
                                                        $after_discount = ($product->price - ($product->price * $product->discount) / 100);
                                                    @endphp
                                                    <span>${{number_format($after_discount, 2)}}</span>
                                                    <del style="padding-left:4%;">${{number_format($product->price, 2)}}</del>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- End Product Area -->
    @php
        $featured=DB::table('products')->where('is_featured',1)->where('status','active')->orderBy('id','DESC')->limit(1)->get();
    @endphp
        <!-- Start Midium Banner  -->
    {{--    <section class="midium-banner">--}}
    {{--        <div class="container">--}}
    {{--            <div class="row">--}}
    {{--                @if($featured)--}}
    {{--                    @foreach($featured as $data)--}}
    {{--                        <!-- Single Banner  -->--}}
    {{--                        <div class="col-lg-6 col-md-6 col-12">--}}
    {{--                            <div class="single-banner">--}}
    {{--                                @php--}}
    {{--                                    $photo=explode(',',$data->photo);--}}
    {{--                                @endphp--}}
    {{--                                <img src="{{$photo[0]}}" alt="{{$photo[0]}}">--}}
    {{--                                <div class="content">--}}
    {{--                                    <p>{{$data->cat_info['title']}}</p>--}}
    {{--                                    <h3>{{$data->title}} <br>Up to<span> {{$data->discount}}%</span></h3>--}}
    {{--                                    <a href="{{route('product-detail',$data->slug)}}">Shop Now</a>--}}
    {{--                                </div>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                        <!-- /End Single Banner  -->--}}
    {{--                    @endforeach--}}
    {{--                @endif--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </section>--}}
    <!-- End Midium Banner -->

    <!-- Start Most Popular -->
    <div class="product-area most-popular section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Hot Item</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="owl-carousel popular-slider">
                        @foreach($product_lists as $product)
                            @if($product->condition=='hot')
                                <!-- Start Single Product -->
                                <div class="single-product">
                                    <div class="product-img">
                                        <a href="{{route('product-detail',$product->slug)}}">
                                            @php
                                                $photo=explode(',',$product->photo);
                                            // dd($photo);
                                            @endphp
                                            <img class="default-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                            <img class="hover-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                            {{-- <span class="out-of-stock">Hot</span> --}}
                                        </a>
                                        <div class="button-head">
                                            <div class="product-action">
                                                <a data-toggle="modal" data-target="#{{$product->id}}" title="Quick View" href="#"><i class=" ti-eye"></i><span>Quick Shop</span></a>
                                                <a title="Wishlist" href="{{route('add-to-wishlist',$product->slug)}}" ><i class=" ti-heart "></i><span>Add to Wishlist</span></a>
                                            </div>
                                            <div class="product-action-2">
                                                <a href="{{route('add-to-cart',$product->slug)}}">Add to cart</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <h3><a href="{{route('product-detail',$product->slug)}}">{{$product->title}}</a></h3>
                                        <div class="product-price">
                                            <span class="old">${{number_format($product->price,2)}}</span>
                                            @php
                                                $after_discount=($product->price-($product->price*$product->discount)/100)
                                            @endphp
                                            <span>${{number_format($after_discount,2)}}</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single Product -->
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Most Popular Area -->

    <!-- Start Shop Home List  -->
    <section class="shop-home-list section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="shop-section-title">
                                <h1>Latest Items</h1>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @php
                            $product_lists=DB::table('products')->where('status','active')->orderBy('id','DESC')->limit(6)->get();
                        @endphp
                        @foreach($product_lists as $product)
                            <div class="col-md-4">
                                <!-- Start Single List  -->
                                <div class="single-list">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-12">
                                            <div class="list-image overlay">
                                                @php
                                                    $photo=explode(',',$product->photo);
                                                    // dd($photo);
                                                @endphp
                                                <img src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                                <a href="{{route('add-to-cart',$product->slug)}}" class="buy"><i
                                                        class="fa fa-shopping-bag"></i></a>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-12 no-padding">
                                            <div class="content">
                                                <h4 class="title"><a href="#">{{$product->title}}</a></h4>
                                                <p class="price with-discount">
                                                    ${{number_format($product->discount,2)}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Single List  -->
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Shop Home List  -->

    <!-- Start Shop Blog  -->
    <section class="shop-blog section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>From Our Blog</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @if($posts)
                    @foreach($posts as $post)
                        <div class="col-lg-4 col-md-6 col-12">
                            <!-- Start Single Blog  -->
                            <div class="shop-single-blog">
                                <img src="{{$post->photo}}" alt="{{$post->photo}}">
                                <div class="content">
                                    <p class="date">{{$post->created_at->format('d M , Y. D')}}</p>
                                    <a href="{{route('blog.detail',$post->slug)}}" class="title">{{$post->title}}</a>
                                    <a href="{{route('blog.detail',$post->slug)}}" class="more-btn">Continue Reading</a>
                                </div>
                            </div>
                            <!-- End Single Blog  -->
                        </div>
                    @endforeach
                @endif

            </div>
        </div>
    </section>
    <!-- End Shop Blog  -->

    <!-- Start Shop Services Area -->
    <section class="shop-services section home">
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
    <!-- End Shop Services Area -->

    @include('frontend.layouts.newsletter')

    <!-- Modal -->
    @if($product_lists)
        @foreach($product_lists as $key=>$product)
            <div class="modal fade" id="{{$product->id}}" tabindex="-1" role="dialog">
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
                                            @php
                                                $photo=explode(',',$product->photo);
                                            // dd($photo);
                                            @endphp
                                            @foreach($photo as $data)
                                                <div class="single-slider">
                                                    <img src="{{$data}}" alt="{{$data}}">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <!-- End Product slider -->
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <div class="quickview-content">
                                        <h2>{{$product->title}}</h2>
                                        <div class="quickview-ratting-review">
                                            <div class="quickview-ratting-wrap">
                                                <div class="quickview-ratting">
                                                    <i class="yellow fa fa-star"></i>
                                                    <i class="yellow fa fa-star"></i>
                                                    <i class="yellow fa fa-star"></i>
                                                    <i class="yellow fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    @php
                                                        $rate=DB::table('product_reviews')->where('product_id',$product->id)->avg('rate');
                                                        $rate_count=DB::table('product_reviews')->where('product_id',$product->id)->count();
                                                    @endphp
                                                    @for($i=1; $i<=5; $i++)
                                                        @if($rate>=$i)
                                                            <i class="yellow fa fa-star"></i>
                                                        @else
                                                            <i class="fa fa-star"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <a href="#"> ({{$rate_count}} customer review)</a>
                                            </div>
                                            <div class="quickview-stock">
                                                @if($product->stock >0)
                                                    <span><i class="fa fa-check-circle-o"></i> {{$product->stock}} in stock</span>
                                                @else
                                                    <span><i class="fa fa-times-circle-o text-danger"></i> {{$product->stock}} out stock</span>
                                                @endif
                                            </div>
                                        </div>
                                        @php
                                            $after_discount=($product->price-($product->price*$product->discount)/100);
                                        @endphp
                                        <h3><small>
                                                <del class="text-muted">${{number_format($product->price,2)}}</del>
                                            </small> ${{number_format($after_discount,2)}}  </h3>
                                        <div class="quickview-peragraph">
                                            <p>{!! html_entity_decode($product->summary) !!}</p>
                                        </div>
                                        @if($product->size)
                                            <div class="size">
                                                <div class="row">
                                                    <div class="col-lg-6 col-12">
                                                        <h5 class="title">Size</h5>
                                                        <select>
                                                            @php
                                                                $sizes=explode(',',$product->size);
                                                                // dd($sizes);
                                                            @endphp
                                                            @foreach($sizes as $size)
                                                                <option>{{$size}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-6 col-12">
                                                        <h5 class="title">Color</h5>
                                                        <select>
                                                            <option selected="selected">orange</option>
                                                            <option>purple</option>
                                                            <option>black</option>
                                                            <option>pink</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <form action="{{route('single-add-to-cart')}}" method="POST" class="mt-4">
                                            @csrf
                                            <div class="quantity">
                                                <!-- Input Order -->
                                                <div class="input-group">
                                                    <div class="button minus">
                                                        <button type="button" class="btn btn-primary btn-number"
                                                                disabled="disabled" data-type="minus"
                                                                data-field="quant[1]">
                                                            <i class="ti-minus"></i>
                                                        </button>
                                                    </div>
                                                    <input type="hidden" name="slug" value="{{$product->slug}}">
                                                    <input type="text" name="quant[1]" class="input-number" data-min="1"
                                                           data-max="1000" value="1">
                                                    <div class="button plus">
                                                        <button type="button" class="btn btn-primary btn-number"
                                                                data-type="plus" data-field="quant[1]">
                                                            <i class="ti-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <!--/ End Input Order -->
                                            </div>
                                            <div class="add-to-cart">
                                                <button type="submit" class="btn">Add to cart</button>
                                                <a href="{{route('add-to-wishlist',$product->slug)}}" class="btn min"><i
                                                        class="ti-heart"></i></a>
                                            </div>
                                        </form>
                                        <div class="default-social">
                                            <!-- ShareThis BEGIN -->
                                                <div class="sharethis-inline-share-buttons"></div><!-- ShareThis END -->
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
        /* Banner Sliding */
        #Gslider .carousel-inner {
            background: #000000;
            color:black;
        }

        #Gslider .carousel-inner{
            height: 550px;
        }
        #Gslider .carousel-inner img{
            width: 100% !important;
            opacity: .8;
        }

        #Gslider .carousel-inner .carousel-caption {
            bottom: 60%;
        }

        #Gslider .carousel-inner .carousel-caption h1 {
            font-size: 50px;
            font-weight: bold;
            line-height: 100%;
            color: red;
        }

        #Gslider .carousel-inner .carousel-caption p {
            font-size: 18px;
            color: black;
            margin: 28px 0 28px 0;
        }

        #Gslider .carousel-indicators {
            bottom: 70px;
        }
    </style>
    <style>
        /* General Styles for Filter Box */
        .filter-box {
            position: absolute;
            top: 50%;
            right: 5rem;
            transform: translateY(-50%);
            z-index: 10;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 40%;
        }

        /* Mobile Styles */
        /* Mobile Styles */
        @media (max-width: 768px) {
            .filter-box {
                width: 90%;
                right: 5%;
                top: 20%;
                transform: translateY(0);
                padding: 10px;
            }

            .filter-options {
                display: flex;
                flex-direction: row; /* Align buttons in a row */
                flex-wrap: wrap; /* Allow wrapping to new line */
                justify-content: space-around; /* Space around buttons */
            }

            .filter-btn {
                flex: 1 1 30%; /* Allow buttons to grow and shrink */
                margin: 5px; /* Margin for spacing */
                padding: 10px 5px; /* Adjust padding */
                text-align: center; /* Center text */
                background-color: #ff0000; /* Red background */
                color: #fff; /* White text */
                border: none; /* Remove border */
                border-radius: 3px; /* Rounded corners */
            }

            .form-row {
                flex-direction: column;
            }

            .form-control {
                width: 100%;
                margin-bottom: 10px;
            }

            .btn.btn-black {
                width: 100%;
            }

            .filter-content {
                margin-top: 15px;
            }
        }

        .filter-content {
            display: none;
        }

        .filter-content.active {
            display: block;
            opacity: 0;
            animation: fadeIn 0.5s forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        .filter-options {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
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



        .form-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .form-control {
            width: 48%;
            color: #ff0000;
        }
        .form-control:hover {

            color: #b30000;
        }

        .btn.btn-black {
            background-color: #000;
            color: #fff;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .btn.btn-black:hover {
            background-color: #b30000; /* Red color on hover */
        }

        .hidden {
            display: none;
        }

        .flex {
            display: flex;
        }


    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('pneu-jantes-form');
            if (form) {
                form.addEventListener('submit', function(event) {
                    submitForm(event, 'pneu-jantes-form');
                });
            }

            var filterModal = new bootstrap.Modal(document.getElementById('filterModal'));

            window.submitForm = function(event, formId) {
                event.preventDefault();
                const form = document.getElementById(formId);
                const formData = new FormData(form);
                const resultsContainer = document.getElementById('filterResults');

                fetch(form.action, {
                    method: form.method,
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.text();
                    })
                    .then(data => {
                        resultsContainer.innerHTML = data;
                        filterModal.show();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('There was an error processing your request. Please try again.');
                    });
            }
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script>

        /*==================================================================
        [ Isotope ]*/
        var $topeContainer = $('.isotope-grid');
        var $filter = $('.filter-tope-group');

        // filter items on button click
        $filter.each(function () {
            $filter.on('click', 'button', function () {
                var filterValue = $(this).attr('data-filter');
                $topeContainer.isotope({filter: filterValue});
            });

        });

        // init Isotope
        $(window).on('load', function () {
            var $grid = $topeContainer.each(function () {
                $(this).isotope({
                    itemSelector: '.isotope-item',
                    layoutMode: 'fitRows',
                    percentPosition: true,
                    animationEngine: 'best-available',
                    masonry: {
                        columnWidth: '.isotope-item'
                    }
                });
            });
        });

        var isotopeButton = $('.filter-tope-group button');

        $(isotopeButton).each(function () {
            $(this).on('click', function () {
                for (var i = 0; i < isotopeButton.length; i++) {
                    $(isotopeButton[i]).removeClass('how-active1');
                }

                $(this).addClass('how-active1');
            });
        });

        // Show and hide filters based on product type
        $('#product_type').change(function () {
            var selectedType = $(this).val();
            $('.product-filters').addClass('d-none');
            if (selectedType == 'pneu') {
                $('#pneu-filters').removeClass('d-none');
            } else if (selectedType == 'pneu_et_jantes') {
                $('#pneu-et-jantes-filters').removeClass('d-none');
            } else if (selectedType == 'roues_et_jantes') {
                $('#roues-et-jantes-filters').removeClass('d-none');
            }
        });

        // Initialize the filter based on the selected type on page load
        $(document).ready(function () {
            var selectedType = $('#product_type').val();
            if (selectedType == 'pneu') {
                $('#pneu-filters').removeClass('d-none');
            } else if (selectedType == 'pneu_et_jantes') {
                $('#pneu-et-jantes-filters').removeClass('d-none');
            } else if (selectedType == 'roues_et_jantes') {
                $('#roues-et-jantes-filters').removeClass('d-none');
            }
        });

    </script>
    <script>
        function cancelFullScreen(el) {
            var requestMethod = el.cancelFullScreen || el.webkitCancelFullScreen || el.mozCancelFullScreen || el.exitFullscreen;
            if (requestMethod) { // cancel full screen.
                requestMethod.call(el);
            } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
                var wscript = new ActiveXObject("WScript.Shell");
                if (wscript !== null) {
                    wscript.SendKeys("{F11}");
                }
            }
        }

        function requestFullScreen(el) {
            // Supports most browsers and their versions.
            var requestMethod = el.requestFullScreen || el.webkitRequestFullScreen || el.mozRequestFullScreen || el.msRequestFullscreen;

            if (requestMethod) { // Native full screen.
                requestMethod.call(el);
            } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
                var wscript = new ActiveXObject("WScript.Shell");
                if (wscript !== null) {
                    wscript.SendKeys("{F11}");
                }
            }
            return false
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.filter-btn').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    document.querySelectorAll('.filter-btn').forEach(function (btn) {
                        btn.classList.remove('active');
                    });
                    btn.classList.add('active');

                    document.querySelectorAll('.filter-content').forEach(function (content) {
                        content.classList.remove('active');
                    });
                    document.querySelector('#' + btn.id.replace('-btn', '-filter')).classList.add('active');
                });
            });
        });


    </script>

@endpush