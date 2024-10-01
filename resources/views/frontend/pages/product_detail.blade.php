@extends('frontend.layouts.master')

@section('meta')
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name='copyright' content=''>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="online shop, purchase, cart, ecommerce site, best online shopping">
    <meta name="description" content="{{$product_detail->summary}}">
    <meta property="og:url" content="{{route('product-detail',$product_detail->slug)}}">
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{$product_detail->title}}">
    <meta property="og:image" content="{{$product_detail->photo}}">
    <meta property="og:description" content="{{$product_detail->description}}">
@endsection
@section('title','E-SHOP || PRODUCT DETAIL')
@section('main-content')

    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="">Shop Details</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

        <!-- Product Style 1 -->
        <section class="product-area shop-sidebar shop-list shop section">
            <div class="container">
                <div class="row">

                    <div class="content-wrapper">
                        <div class="row">
                            <!-- Sidebar Navigation (Nav-Pills) -->
                            <div class="col-lg-3 col-md-4 col-12">
                                <div class="nav-pills">
                                    <div class="single-widget">

                                        <ul class="nav nav-pills nav-stacked" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="presentation-tab" data-toggle="tab"
                                                   href="#presentation" role="tab" aria-controls="presentation"
                                                   aria-selected="true">
                                                    <i class="fa fa-eye"></i> Présentation
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="specifications-tab" data-toggle="tab"
                                                   href="#specifications" role="tab" aria-controls="specifications"
                                                   aria-selected="false">
                                                    <i class="fa fa-cogs"></i> Spécifications
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="avis-client-tab" data-toggle="tab"
                                                   href="#avis-client"
                                                   role="tab" aria-controls="avis-client" aria-selected="false">
                                                    <i class="fa fa-comment"></i> Avis client
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Main Product Content -->
                            <div class="col-lg-9 col-md-8 col-12">
                                <div class="tab-content">
                                    <!-- Presentation Tab Content -->
                                    <div class="tab-pane fade show active" id="presentation" role="tabpanel"
                                         aria-labelledby="presentation-tab">
                                        <div class="product-container">
                                            <div class="row">
                                                <!-- Tire Image Section -->
                                                <div class="col-md-5">
                                                    <div class="img-pneu text-center">
                                                        <img
                                                            src="https://d2raphc8m6em86.cloudfront.net/27582/conversions/rotalla-s130-medium.jpg"
                                                            itemprop="image" alt="Rotalla S130 Pneu d'hiver"
                                                            class="img-responsive" style="width:300px">

                                                        <form action="{{route('single-add-to-cart')}}" method="POST">
                                                            @csrf
                                                            <div class="quantity">

                                                                <!-- Input Order -->
                                                                <div class="input-group">
                                                                    <div class="button minus">
                                                                        <button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
                                                                            <i class="ti-minus"></i>
                                                                        </button>
                                                                    </div>
                                                                    <input type="hidden" name="slug" value="{{$product_detail->slug}}">
                                                                    <input type="text" name="quant[1]" class="input-number"  data-min="1" data-max="1000" value="1" id="quantity">
                                                                    <div class="button plus">
                                                                        <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[1]">
                                                                            <i class="ti-plus"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <!--/ End Input Order -->
                                                            </div>
                                                            <div class="add-to-cart mt-4">
                                                                <button type="submit" class="btn-red">Add to cart</button>
                                                                <a href="{{route('add-to-wishlist',$product_detail->slug)}}" class="btn min"><i class="ti-heart"></i></a>
                                                            </div>
                                                        </form>

                                                    </div>
                                                </div>


                                                <!-- Product Information Section -->
                                                <div class="col-md-7">
                                                    <div class="information-supp">
                                                        <h1 class="brand-title">{{$product_detail->brand}}</h1>
                                                        <div class="tire-info">
                                                            <div class="tire-dimension">
                                                                <h3>Dimension</h3>
                                                                <p>{{$product_detail->width}}
                                                                    /{{$product_detail->aspect_ratio}}
                                                                    R{{$product_detail->diameter}} - 91V</p>
                                                            </div>
                                                            <div class="price">
                                                                {{$product_detail->price}}<sup>95$</sup>
                                                                <span class="availability">En stock</span>
                                                            </div>
                                                        </div>
                                                        <div class="features">
                                                            {!! $product_detail->summary !!}
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Product Description -->
                                            <div class="description">
                                                <p>{!! $product_detail->description !!}</p>
                                            </div>

                                        </div>
                                    </div>

                                    <!-- Specifications Tab Content -->

                                    <div class="tab-pane fade" id="specifications" role="tabpanel"
                                         aria-labelledby="specifications-tab">
                                        <h3>Spécifications</h3>
                                        <div class="row" >
                                            <div class="col-md-6">
                                                <table class="table specification-pneu">
                                                    <tbody>
                                                    <tr>
                                                        <td>Manufacturier</td>
                                                        <td>{{$product_detail->brand}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Cloutable</td>
                                                        <td>{{ $specifications['Cloutable'] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Saison</td>
                                                        <td>{{$product_detail->season}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Code produit</td>
                                                        <td>{{$product_detail->code}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Largeur du pneu</td>
                                                        <td>{{$product_detail->width}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Ratio du pneu</td>
                                                        <td>{{$product_detail->aspect_ratio}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Diamètre du pneu</td>
                                                        <td>{{$product_detail->diameter}}</td>
                                                    </tr>

                                                    <tr>
                                                        <td>Indice de charge</td>
                                                        <td>91</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Indice de vitesse</td>
                                                        <td>V</td>
                                                    </tr>

                                                    <tr class="specification-pneu-mobile">
                                                        <td>Flancs porteurs (Runflat)</td>
                                                        <td>{{ $specifications['Flancs porteurs (Runflat)'] }}</td>
                                                    </tr>
                                                    <tr class="specification-pneu-mobile">
                                                        <td>Pneu renforcé</td>
                                                        <td>{{ $specifications['Pneu renforcé'] }}</td>
                                                    </tr>
                                                    <tr class="specification-pneu-mobile">
                                                        <td>Extra Load</td>
                                                        <td>{{ $specifications['Extra Load'] }}</td>
                                                    </tr>


                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="col-md-6">
                                                <table class="table specification-pneu specification-route">
                                                    <tbody>
                                                    <tr>
                                                        <td>Flancs porteurs (Runflat)</td>
                                                        <td>{{ $specifications['Flancs porteurs (Runflat)'] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pneu renforcé</td>
                                                        <td>{{ $specifications['Pneu renforcé'] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Extra Load</td>
                                                        <td>{{ $specifications['Extra Load'] }}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Avis Client Tab Content -->

                                    <!-- Reviews Tab -->
                                    <div class="tab-pane fade" id="avis-client" role="tabpanel"
                                         aria-labelledby="avis-client-tab">
                                        <h3>Avis Client</h3>
                                        <div class="tab-single review-panel">
                                            <div class="row">
                                                <div class="col-12">
                                                    <!-- Review Section -->
                                                    <div class="comment-review">
                                                        <div class="add-review mb-4">
                                                            <h5>Add A Review</h5>
                                                            <p>Your email address will not be published. Required fields
                                                                are marked.</p>
                                                        </div>
                                                        <h4>Your Rating <span class="text-danger">*</span></h4>
                                                        <div class="review-inner">
                                                            @auth
                                                                <form class="form" method="post"
                                                                      action="{{route('review.store',$product_detail->slug)}}">
                                                                    @csrf
                                                                    <div class="row">
                                                                        <div class="col-lg-12 col-12 mb-3">
                                                                            <div class="rating_box">
                                                                                <div class="star-rating">
                                                                                    <div class="star-rating__wrap">
                                                                                        @for($i = 5; $i >= 1; $i--)
                                                                                            <input
                                                                                                class="star-rating__input"
                                                                                                id="star-rating-{{ $i }}"
                                                                                                type="radio" name="rate"
                                                                                                value="{{ $i }}">
                                                                                            <label
                                                                                                class="star-rating__ico fa fa-star-o"
                                                                                                for="star-rating-{{ $i }}"
                                                                                                title="{{ $i }} out of 5 stars"></label>
                                                                                        @endfor
                                                                                        @error('rate')
                                                                                        <span
                                                                                            class="text-danger">{{ $message }}</span>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12 col-12 mb-3">
                                                                            <div class="form-group">
                                                                                <label>Write a review</label>
                                                                                <textarea name="review" rows="6"
                                                                                          class="form-control"
                                                                                          placeholder="Share your thoughts..."></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-12 col-12">
                                                                            <div class="form-group">
                                                                                <button type="submit" class="btn-red">
                                                                                    Submit
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            @else
                                                                <p class="text-center p-5">
                                                                    You need to <a href="{{ route('login.form') }}"
                                                                                   style="color:rgb(54, 54, 204)">Login</a>
                                                                    OR <a style="color:blue"
                                                                          href="{{ route('register.form') }}">Register</a>
                                                                </p>
                                                            @endauth
                                                        </div>
                                                    </div>

                                                    <div class="ratting-main mt-4">
                                                        <div class="avg-ratting mb-4">
                                                            <h4>{{ ceil($product_detail->getReview->avg('rate')) }}
                                                                <span>(Overall)</span></h4>
                                                            <span>Based on {{ $product_detail->getReview->count() }} Comments</span>
                                                        </div>
                                                        @foreach($product_detail['getReview'] as $data)
                                                            <!-- Single Rating -->
                                                            <div class="single-rating mb-3">
                                                                <div class="rating-author">
                                                                    @if($data->user_info['photo'])
                                                                        <img src="{{ $data->user_info['photo'] }}"
                                                                             alt="{{ $data->user_info['name'] }}"
                                                                             class="rounded-circle" width="50">
                                                                    @else
                                                                        <img src="{{ asset('backend/img/avatar.png') }}"
                                                                             alt="Profile.jpg" class="rounded-circle"
                                                                             width="50">
                                                                    @endif
                                                                </div>
                                                                <div class="rating-des">
                                                                    <h6>{{ $data->user_info['name'] }}</h6>
                                                                    <div class="ratings">
                                                                        <ul class="rating">
                                                                            @for($i = 1; $i <= 5; $i++)
                                                                                @if($data->rate >= $i)
                                                                                    <li>
                                                                                        <i class="fa fa-star text-warning"></i>
                                                                                    </li>
                                                                                @else
                                                                                    <li><i class="fa fa-star-o"></i>
                                                                                    </li>
                                                                                @endif
                                                                            @endfor
                                                                        </ul>
                                                                        <div class="rate-count">
                                                                            (<span>{{ $data->rate }}</span>)
                                                                        </div>
                                                                    </div>
                                                                    <p>{{ $data->review }}</p>
                                                                </div>
                                                            </div>
                                                            <!--/ End Single Rating -->
                                                        @endforeach
                                                    </div>
                                                    <!--/ End Review -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Add your CSS Styles here -->
                                    <style>
                                        /* Enhancements for the "Avis Client" (Customer Reviews) Section */

                                        /* Review panel container */
                                        .review-panel {
                                            background-color: #f9f9f9;
                                            padding: 20px;
                                            border-radius: 10px;
                                            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                                            margin-bottom: 20px;
                                        }

                                        /* Review title */
                                        .review-panel h3 {
                                            font-size: 24px;
                                            font-weight: bold;
                                            color: #333;
                                            margin-bottom: 20px;
                                            border-bottom: 2px solid #c30000;
                                            padding-bottom: 10px;
                                        }

                                        /* Review box */
                                        .single-rating {
                                            background-color: #fff;
                                            padding: 20px;
                                            border-radius: 10px;
                                            margin-bottom: 20px;
                                            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
                                            transition: box-shadow 0.3s ease;
                                        }

                                        .single-rating:hover {
                                            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
                                        }

                                        /* Review author image */
                                        .rating-author img {
                                            border-radius: 50%;
                                            border: 2px solid #ddd;
                                            width: 60px;
                                            height: 60px;
                                            object-fit: cover;
                                        }

                                        /* Review author name and rating */
                                        .rating-des h6 {
                                            font-size: 18px;
                                            font-weight: bold;
                                            margin-bottom: 5px;
                                            color: #333;
                                        }

                                        .ratings {
                                            display: flex;
                                            align-items: center;
                                        }

                                        .ratings ul.rating {
                                            list-style-type: none;
                                            padding: 0;
                                            display: flex;
                                            margin: 0;
                                        }

                                        .ratings ul.rating li {
                                            color: #f39c12;
                                            font-size: 1.5rem;
                                            margin-right: 2px;
                                        }

                                        .ratings .fa-star-o {
                                            color: #ddd;
                                        }

                                        /* Review content */
                                        .single-rating p {
                                            font-size: 16px;
                                            color: #555;
                                            line-height: 1.6;
                                            margin-top: 10px;
                                        }

                                        /* Review submission form */
                                        .add-review {
                                            background-color: #fff;
                                            padding: 20px;
                                            border-radius: 10px;
                                            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
                                            margin-bottom: 20px;
                                        }

                                        .add-review h5 {
                                            font-size: 20px;
                                            font-weight: bold;
                                            color: #333;
                                            margin-bottom: 10px;
                                        }

                                        .add-review p {
                                            color: #555;
                                            font-size: 14px;
                                            margin-bottom: 15px;
                                        }

                                        .add-review label {
                                            font-size: 16px;
                                            font-weight: bold;
                                            color: #333;
                                            margin-bottom: 5px;
                                            display: block;
                                        }

                                        .add-review textarea {
                                            width: 100%;
                                            padding: 10px;
                                            border-radius: 8px;
                                            border: 1px solid #ddd;
                                            font-size: 16px;
                                            resize: none;
                                            height: 120px;
                                        }

                                        .add-review .btn-red {
                                            margin-top: 10px;
                                            width: 150px;
                                        }

                                        /* Star rating */
                                        .star-rating__ico {
                                            cursor: pointer;
                                            color: #ddd; /* default unselected star color */
                                            transition: color 0.2s ease-in-out;
                                        }
                                        .star-rating__ico:hover,
                                        .star-rating__ico:hover ~ .star-rating__ico,
                                        .star-rating__input:checked ~ .star-rating__ico {
                                            color: #ffc107; /* color when hovering or selected */
                                        }
                                        .star-rating__ico:hover {
                                            color: #e67e22;
                                        }

                                        .star-rating__wrap {
                                            display: flex;
                                            font-size: 2rem;
                                            margin-bottom: 10px;
                                            direction: rtl; /* reverse the star order */
                                        }
                                        .star-rating__input {
                                            display: none; /* hide the radio buttons */
                                        }
                                        /* Average rating */
                                        .avg-ratting {
                                            text-align: center;
                                            margin-bottom: 20px;
                                        }

                                        .avg-ratting h4 {
                                            font-size: 40px;
                                            font-weight: bold;
                                            color: #c30000;
                                        }

                                        .avg-ratting span {
                                            font-size: 16px;
                                            color: #666;
                                        }

                                        /* Comments count */
                                        .avg-ratting span {
                                            color: #555;
                                        }

                                        /* Mobile responsiveness */
                                        @media only screen and (max-width: 768px) {
                                            .single-rating {
                                                padding: 15px;
                                            }

                                            .rating-author img {
                                                width: 50px;
                                                height: 50px;
                                            }

                                            .ratings ul.rating li {
                                                font-size: 1.2rem;
                                            }

                                            .single-rating p {
                                                font-size: 14px;
                                            }
                                        }

                                    </style>

                                    <!--/ End Reviews Tab -->
                                </div>
                            </div>

                            <!-- Add your CSS Styles here -->


                        </div>
                    </div>
                </div>
            </div>

            </div>
            </div>
        </section>




    <!-- Start Most Popular -->
    <div class="product-area most-popular related-product section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Related Products</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                {{-- {{$product_detail->rel_prods}} --}}
                <div class="col-12">
                    <div class="owl-carousel popular-slider">
                        @foreach($product_detail->rel_prods as $data)
                            @if($data->id !==$product_detail->id)
                                <!-- Start Single Product -->
                                <div class="single-product">
                                    <div class="product-img">
                                        <a href="{{route('product-detail',$data->slug)}}">
                                            @php
                                                $photo=explode(',',$data->photo);
                                            @endphp
                                            <img class="default-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                            <img class="hover-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                            <span class="price-dec">{{$data->discount}} % Off</span>
                                            {{-- <span class="out-of-stock">Hot</span> --}}
                                        </a>


                                        <div class="button-head">
                                            <div class="product-action">
                                                <a data-toggle="modal" data-target="#modelExample" title="Quick View"
                                                   href="#"><i class=" ti-eye"></i><span>Quick Shop</span></a>
                                                <a title="Wishlist" href="#"><i class=" ti-heart "></i><span>Add to Wishlist</span></a>
                                                <a title="Compare" href="#"><i class="ti-bar-chart-alt"></i><span>Add to Compare</span></a>
                                            </div>
                                            <div class="product-action-2">
                                                <a title="Add to cart" href="#">Add to cart</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <h3><a href="{{route('product-detail',$data->slug)}}">{{$data->title}}</a></h3>
                                        <div class="product-price">
                                            @php
                                                $after_discount=($data->price-(($data->discount*$data->price)/100));
                                            @endphp
                                            <span class="old">${{number_format($data->price,2)}}</span>
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

    <div class="modal fade" id="modelExample" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="ti-close"
                                                                                                      aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row no-gutters">
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <!-- Product Slider -->
                            <div class="product-gallery">
                                <div class="quickview-slider-active">
                                    <div class="single-slider">
                                        <img src="images/modal1.png" alt="#">
                                    </div>
                                    <div class="single-slider">
                                        <img src="images/modal2.png" alt="#">
                                    </div>
                                    <div class="single-slider">
                                        <img src="images/modal3.png" alt="#">
                                    </div>
                                    <div class="single-slider">
                                        <img src="images/modal4.png" alt="#">
                                    </div>
                                </div>
                            </div>
                            <!-- End Product slider -->
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="quickview-content">
                                <h2>Flared Shift Dress</h2>
                                <div class="quickview-ratting-review">
                                    <div class="quickview-ratting-wrap">
                                        <div class="quickview-ratting">
                                            <i class="yellow fa fa-star"></i>
                                            <i class="yellow fa fa-star"></i>
                                            <i class="yellow fa fa-star"></i>
                                            <i class="yellow fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <a href="#"> (1 customer review)</a>
                                    </div>
                                    <div class="quickview-stock">
                                        <span><i class="fa fa-check-circle-o"></i> in stock</span>
                                    </div>
                                </div>
                                <h3>$29.00</h3>
                                <div class="quickview-peragraph">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Mollitia iste laborum
                                        ad impedit pariatur esse optio tempora sint ullam autem deleniti nam in quos qui
                                        nemo ipsum numquam.</p>
                                </div>
                                <div class="size">
                                    <div class="row">
                                        <div class="col-lg-6 col-12">
                                            <h5 class="title">Size</h5>
                                            <select>
                                                <option selected="selected">s</option>
                                                <option>m</option>
                                                <option>l</option>
                                                <option>xl</option>
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
                                <div class="quantity">
                                    <!-- Input Order -->
                                    <div class="input-group">
                                        <div class="button minus">
                                            <button type="button" class="btn btn-primary btn-number" disabled="disabled"
                                                    data-type="minus" data-field="quant[1]">
                                                <i class="ti-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text" name="qty" class="input-number" data-min="1" data-max="1000"
                                               value="1">
                                        <div class="button plus">
                                            <button type="button" class="btn btn-primary btn-number" data-type="plus"
                                                    data-field="quant[1]">
                                                <i class="ti-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!--/ End Input Order -->
                                </div>
                                <div class="add-to-cart">
                                    <a href="#" class="btn">Add to cart</a>
                                    <a href="#" class="btn min"><i class="ti-heart"></i></a>
                                    <a href="#" class="btn min"><i class="fa fa-compress"></i></a>
                                </div>
                                <div class="default-social">
                                    <h4 class="share-now">Share:</h4>
                                    <ul>
                                        <li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                                        <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                                        <li><a class="youtube" href="#"><i class="fa fa-pinterest-p"></i></a></li>
                                        <li><a class="dribbble" href="#"><i class="fa fa-google-plus"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection



@push('styles')
    <style>
        /* Align the button and input field horizontally */
        .d-flex {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 15px;
        }

        .justify-content-between {
            justify-content: space-between;
        }

        .align-items-center {
            align-items: center;
        }

        .form-control.qty-input {
            max-width: 80px; /* Slightly increased width */
            text-align: center;
            padding: 12px;
            border-radius: 8px; /* Added rounded corners */
            border: 1px solid #ddd; /* Subtle border */
            font-size: 1.2rem;
            margin-right: 10px;
        }

        .btn-red {
            background-color: #c30000;
            border: none;
            padding: 12px 20px;
            color: white;
            font-size: 1rem;
            cursor: pointer;
            text-transform: uppercase;
            display: inline-block;
            border-radius: 8px; /* Added border radius */
            transition: background-color 0.3s ease;
        }

        .btn-red:hover {
            background-color: #a80000;
        }

        /* Centering image inside its div */
        .img-pneu img {
            width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add subtle shadow */
            transition: transform 0.3s ease; /* Add hover effect */
        }

        .img-pneu img:hover {
            transform: scale(1.05); /* Slight zoom on hover */
        }

        /* Make sure everything is responsive */
        @media only screen and (max-width: 768px) {
            .d-flex {
                flex-direction: column;
            }

            .form-control.qty-input {
                margin-bottom: 10px;
                width: 100%;
            }

            .btn-red {
                width: 100%;
            }
        }

        /* General Reset and Navigation Styling */
        .single-widget .nav-link {
            color: #000000;
            text-decoration: none;
        }

        .nav-pills .nav-link {
            border-radius: 8px;
            background-color: #f1f1f1; /* Light grey background */
            color: #333333; /* Dark text color */
            font-weight: bold;
            padding: 10px 20px;
            text-align: center;
            text-transform: uppercase;
            transition: all 0.3s ease;
            width: 15rem;
            margin: 0.5rem 0;
        }

        /* Active and Hover Styles for Navigation Links */
        .nav-link.active {
            background-color: #c30000 !important;
            color: #fff; /* White text for contrast */
        }

        .nav-link:hover {
            color: #555555; /* Darker grey on hover */
        }

        /* Button Styling */
        .btn-red {
            background-color: #c30000;
            border: 0;
            border-bottom: 4px solid #6e0000;
            border-radius: 8px;
            color: #fff;
            font-family: "Arial", sans-serif;
            font-size: 14px;
            font-weight: bold;
            padding: 12px 20px;
            text-align: center;
            text-transform: uppercase;
            max-width: 300px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            top: 0;
        }

        .btn-red:hover {
            background-color: #a80000;
            border-bottom-color: #580000;
            top: -2px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-red:active {
            background-color: #8e0000;
            border-bottom-color: #400000;
            top: 2px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        }

        /* Responsive Button Adjustments */
        @media only screen and (max-width: 990px) {
            .btn-red {
                font-size: 10px;
                width: 77%;
            }
        }

        @media only screen and (max-width: 1200px) {
            .btn-red {
                font-size: 13px;
                width: 78%;
            }
        }

        /* Product Container Styles */
        .product-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            transition: box-shadow 0.3s ease;
        }

        .product-container:hover {
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        /* Product title */
        .product-container h1 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            align-items: stretch; /* Equal height columns */
        }

        .col-md-5,
        .col-md-7 {
            padding: 20px;
        }

        /* Image and Text Section Styling */
        .img-pneu {
            text-align: center;
        }

        .img-pneu img {
            max-width: 100%;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .img-pneu img:hover {
            transform: scale(1.05);
        }

        .information-supp {
            padding-left: 30px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .brand-title {
            color: #333;
            font-size: 2.5rem;
        }

        .tire-info {
            margin-bottom: 20px;
        }

        .price {
            font-size: 2.5rem;
            color: #c30000;
        }

        .availability {
            font-size: 0.9rem;
            background-color: #5ca331;
            color: white;
            padding: 4px 8px;
            border-radius: 5px;
        }

        /* Features and Icons */
        .features {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .features li {
            background-color: grey;
            color: black;
            padding: 8px 12px;
            margin-bottom: 5px;
            border-radius: 4px;
            display: flex;
            align-items: center;
        }

        .features li::before {
            content: '\2714'; /* Unicode character for a checkmark */
            margin-right: 10px;
            font-weight: bold;
            color: #4CAF50; /* A green color for the checkmark */
        }

        .icon-set img {
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }

        /* Description Section */
        .description {
            font-size: 1.2rem;
            line-height: 1.8;
            margin-top: 20px;
            padding: 20px;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        #presentation h1 {
            font-size: 2.2rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }
        /* Specifications Section */
        #specifications {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        /* Unified box-shadow for all sections (Avis Client, Specifications, Presentation) */
        .product-container, .specification-pneu, .review-panel {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05); /* Consistent shadow */
            margin-bottom: 30px;
        }
        .tab-pane h3, .product-container h1 {
            font-size: 2.2rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #c30000; /* Red underline for consistency */
        }
        #specifications h3 {
            font-size: 2.2rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
            border-bottom: 2px solid #c30000;
            padding-bottom: 10px;
        }

        /* Specification tables */
        .specification-pneu {
            width: 100%;
            background-color: #f9f9f9;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        .specification-pneu th,
        .specification-pneu td {
            padding: 12px;
            font-size: 1.2rem;
            color: #444;
        }

        .specification-pneu td:first-child {
            font-weight: bold;
            color: #666;
        }

        .specification-pneu td {
            border-bottom: 1px solid #ddd;
        }

        .specification-pneu tbody tr:last-child td {
            border-bottom: none;
        }

        /* Alternating row colors */
        .specification-pneu tr:nth-child(even) {
            background-color: #f0f0f0;
        }

        .specification-pneu td {
            transition: background-color 0.2s ease;
        }

        .specification-pneu td:hover {
            background-color: #f5f5f5;
        }

        /* Align nav-pills with the product container */
        .nav-pills {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        /* Mobile responsiveness */
        @media only screen and (max-width: 768px) {
            .specification-pneu {
                font-size: 0.9rem;
            }

            #specifications h3 {
                font-size: 1.8rem;
            }
        }

    </style>
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    {{-- <script>
        $('.cart').click(function(){
            var quantity=$('#quantity').val();
            var pro_id=$(this).data('id');
            // alert(quantity);
            $.ajax({
                url:"{{route('add-to-cart')}}",
                type:"POST",
                data:{
                    _token:"{{csrf_token()}}",
                    quantity:quantity,
                    pro_id:pro_id
                },
                success:function(response){
                    console.log(response);
					if(typeof(response)!='object'){
						response=$.parseJSON(response);
					}
					if(response.status){
						swal('success',response.msg,'success').then(function(){
							document.location.href=document.location.href;
						});
					}
					else{
                        swal('error',response.msg,'error').then(function(){
							document.location.href=document.location.href;
						});
                    }
                }
            })
        });
    </script> --}}

@endpush
