@extends('frontend.layouts.master')

@section('meta')
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name='copyright' content=''>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="boutique en ligne, achat, panier, site ecommerce, meilleur shopping en ligne">
    <meta name="description" content="{{$product_detail->summary}}">
    <meta property="og:url" content="{{route('product-detail',$product_detail->slug)}}">
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{$product_detail->title}}">
    <meta property="og:image" content="{{$product_detail->photo}}">
    <meta property="og:description" content="{{$product_detail->description}}">
@endsection
@section('title','E-SHOP || DÉTAIL DU PRODUIT')
@section('main-content')

    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{route('home')}}">Accueil<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="">Détails du Produit</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Breadcrumbs -->

    <!-- Style du Produit -->
    <section class="product-area shop-sidebar shop-list shop section">
        <div class="container">
            <div class="row">

                <div class="content-wrapper">
                    <div class="row">
                        <!-- Navigation Sidebar (Nav-Pills) -->
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

                        <!-- Contenu Principal du Produit -->
                        <div class="col-lg-9 col-md-8 col-12">
                            <div class="tab-content">
                                <!-- Contenu de l'onglet Présentation -->
                                <div class="tab-pane fade show active" id="presentation" role="tabpanel" aria-labelledby="presentation-tab">
                                    <div class="product-container">
                                        <div class="row">
                                            <!-- Section Image du Produit -->
                                            <div class="col-md-5">
                                                <div class="img-pneu text-center">
                                                    <img src="https://d2raphc8m6em86.cloudfront.net/27582/conversions/rotalla-s130-medium.jpg" itemprop="image" alt="Rotalla S130 Pneu d'hiver" class="img-responsive" style="width:300px">
                                                    <form action="{{route('single-add-to-cart')}}" method="POST">
                                                        @csrf
                                                        <div class="quantity">
                                                            <br>
                                                            <!-- Input Order -->
                                                            <div class="input-group">
                                                                <div class="button minus mr-1" >
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

                                            <!-- Section Information du Produit -->
                                            <div class="col-md-7">
                                                <div class="information-supp">
                                                    <h1 class="brand-title">{{$product_detail->brand}}</h1>
                                                    <div class="tire-info">
                                                        <div class="tire-dimension">
                                                            <h3>Dimensions</h3>
                                                            <p>{{$product_detail->width}}/{{$product_detail->aspect_ratio}} R{{$product_detail->diameter}} - 91V</p>
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

                                        <!-- Description du Produit -->
                                        <div class="description">
                                            <p>{!! $product_detail->description !!}</p>
                                        </div>

                                    </div>
                                </div>

                                <!-- Contenu de l'onglet Spécifications -->
                                <div class="tab-pane fade" id="specifications" role="tabpanel" aria-labelledby="specifications-tab">
                                    <h3>Spécifications</h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <table class="table specification-pneu">
                                                <tbody>
                                                <tr>
                                                    <td>Manufacturier</td>
                                                    <td>{{$product_detail->brand}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Poids de livraison</td>
                                                    <td>{{$product_detail->shipping_weight}}</td>
                                                </tr>
                                                <tr>
                                                    <td>Type de service</td>
                                                    <td>{{$product_detail->service_type}}</td>
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


                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <table class="table specification-pneu specification-route">
                                                <tbody>
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
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- Contenu de l'onglet Avis Client -->

                                <!-- Avis Client -->
                                <div class="tab-pane fade" id="avis-client" role="tabpanel" aria-labelledby="avis-client-tab">
                                    <h3>Avis Client</h3>
                                    <div class="tab-single review-panel">
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-sm-12">
                                                <div class="comment-review">
                                                    <div class="add-review mb-4">
                                                        <h5>Ajouter un Avis</h5>
                                                        <p>Votre adresse e-mail ne sera pas publiée. Les champs obligatoires sont indiqués.</p>
                                                    </div>
                                                    <h4>Votre Évaluation <span class="text-danger">*</span></h4>
                                                    <div class="review-inner">
                                                        @auth
                                                            <form class="form" method="post" action="{{route('review.store',$product_detail->slug)}}">
                                                                @csrf
                                                                <div class="row">
                                                                    <div class="col-lg-12 col-12 mb-3">
                                                                        <div class="rating_box">
                                                                            <div class="star-rating">
                                                                                <div class="star-rating__wrap">
                                                                                    @for($i = 5; $i >= 1; $i--)
                                                                                        <input class="star-rating__input" id="star-rating-{{ $i }}" type="radio" name="rate" value="{{ $i }}">
                                                                                        <label class="star-rating__ico fa fa-star" for="star-rating-{{ $i }}" title="{{ $i }} sur 5 étoiles"></label>
                                                                                    @endfor
                                                                                    @error('rate')
                                                                                    <span class="text-danger">{{ $message }}</span>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-12 col-12 mb-3">
                                                                        <div class="form-group">
                                                                            <label>Écrire un avis</label>
                                                                            <textarea name="review" rows="6" class="form-control" placeholder="Partagez vos impressions..."></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-12 col-12">
                                                                        <div class="form-group">
                                                                            <button type="submit" class="btn-red">Soumettre</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        @else
                                                            <p class="text-center p-5">
                                                                Vous devez <a href="{{ route('login.form') }}" style="color:rgb(54, 54, 204)">vous connecter</a> OU <a style="color:blue" href="{{ route('register.form') }}">vous inscrire</a>
                                                            </p>
                                                        @endauth
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <div class="ratting-main mt-4">
                                                    <div class="avg-ratting mb-4">
                                                        <h4>{{ ceil($product_detail->getReview->avg('rate')) }}<span>(Global)</span></h4>
                                                        <span>Basé sur {{ $product_detail->getReview->count() }} Commentaires</span>
                                                    </div>
                                                    @foreach($product_detail['getReview'] as $data)
                                                        <!-- Avis Client Individuel -->
                                                        <div class="single-rating mb-3 d-flex align-items-center">
                                                            <div class="rating-author mr-3">
                                                                @if($data->user_info['photo'])
                                                                    <img src="{{ $data->user_info['photo'] }}" alt="{{ $data->user_info['name'] }}" class="rounded-circle" width="50">
                                                                @else
                                                                    <img src="{{ asset('backend/img/avatar.png') }}" alt="Profile.jpg" class="rounded-circle" width="50">
                                                                @endif
                                                            </div>
                                                            <div class="rating-des">
                                                                <h6>{{ $data->user_info['name'] }}</h6>
                                                                <div class="ratings d-flex align-items-center">
                                                                    <ul class="rating d-flex list-unstyled mb-0">
                                                                        @for($i = 1; $i <= 5; $i++)
                                                                            @if($data->rate >= $i)
                                                                                <li><i class="fa fa-star text-warning"></i></li>
                                                                            @else
                                                                                <li><i class="fa fa-star-o"></i></li>
                                                                            @endif
                                                                        @endfor
                                                                    </ul>
                                                                    <div class="rate-count ml-2">
                                                                        (<span>{{ $data->rate }}</span>)
                                                                    </div>
                                                                </div>
                                                                <p>{{ $data->review }}</p>
                                                            </div>
                                                        </div>
                                                        <!--/ Fin de l'avis client -->
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Vos Styles CSS personnalisés -->
                                <style>

                                    /* Évaluation par étoiles */
                                    .star-rating__wrap {
                                        display: inline-flex;
                                        justify-content: center;
                                    }

                                    .star-rating__ico {
                                        font-size: 24px;
                                        cursor: pointer;
                                        color: #ccc; /* Couleur des étoiles non sélectionnées */
                                        transition: color 0.2s ease-in-out;
                                    }

                                    .star-rating__input {
                                        display: none; /* Masquer les boutons radio */
                                    }

                                    /* Étoiles remplies */
                                    .star-rating__input:checked ~ .star-rating__ico,
                                    .star-rating__ico:hover ~ .star-rating__ico {
                                        color: #ffd700; /* Couleur des étoiles sélectionnées */
                                    }

                                    /* Remplir les étoiles jusqu'à celle sélectionnée */
                                    .star-rating__input:checked ~ .star-rating__ico:nth-child(-n+5),
                                    .star-rating__input:checked ~ .star-rating__ico:nth-child(-n+4),
                                    .star-rating__input:checked ~ .star-rating__ico:nth-child(-n+3),
                                    .star-rating__input:checked ~ .star-rating__ico:nth-child(-n+2),
                                    .star-rating__input:checked ~ .star-rating__ico:nth-child(-n+1) {
                                        color: #ffd700; /* Couleur des étoiles remplies */
                                    }

                                    /* Effet hover pour une meilleure clarté */
                                    .star-rating__ico:hover,
                                    .star-rating__ico:hover ~ .star-rating__ico {
                                        color: #916101; /* Couleur au survol des étoiles */
                                    }


                                    /* Section Avis */
                                    .comment-review {
                                        padding: 20px;
                                        border: 1px solid #e0e0e0;
                                        border-radius: 8px;
                                        background-color: #f8f9fa;
                                        margin-bottom: 20px;
                                    }

                                    .comment-review h5 {
                                        font-weight: bold;
                                    }

                                    .comment-review h4 {
                                        margin-top: 15px;
                                        margin-bottom: 15px;
                                    }

                                    .form-group textarea {
                                        border-radius: 5px;
                                        resize: none;
                                    }



                                    /* Section d'affichage des avis */
                                    .ratting-main {
                                        border-top: 1px solid #ddd;
                                        padding-top: 20px;
                                    }

                                    .avg-ratting {
                                        display: flex;
                                        align-items: center;
                                        font-size: 1.2em;
                                    }

                                    .avg-ratting h4 {
                                        font-weight: bold;
                                        margin-right: 10px;
                                    }

                                    .rating-des h6 {
                                        font-size: 1.1em;
                                        font-weight: bold;
                                    }

                                    .rating-des p {
                                        font-size: 0.9em;
                                        color: #666;
                                    }

                                    .ratings ul {
                                        display: flex;
                                        list-style: none;
                                        padding: 0;
                                    }

                                    .ratings ul li {
                                        margin-right: 5px;
                                    }

                                    .fa-star, .fa-star-o {
                                        color: #ffd700;
                                        font-size: 20px;
                                    }

                                    .rate-count {
                                        font-size: 0.9em;
                                        color: #999;
                                    }

                                    .add-to-cart {
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                    }

                                    .input-group {
                                        margin-right: 15px;
                                    }



                                    .btn-primary.btn-number {
                                        background-color: #c30000;
                                        border: none;
                                        border-radius: 8px;
                                        color: #fff;
                                        width: 40px;
                                        height: 40px;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        transition: background-color 0.3s ease;
                                    }

                                    .btn-primary.btn-number:hover {
                                        background-color: #a80000;
                                    }

                                    .btn-primary.btn-number:disabled {
                                        background-color: #ccc;
                                        cursor: not-allowed;
                                    }

                                    .input-number {
                                        text-align: center;
                                        border: 1px solid #ddd;
                                        border-radius: 8px;
                                        padding: 5px;
                                        width: 60px;
                                        margin: 0 5px;
                                        font-size: 1.2rem;
                                    }
                                </style>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        </div>
        </div>
    </section>




    <!-- Début Produits Connexes -->
    <div class="product-area most-popular related-product section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Produits Connexes</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                {{-- {{$product_detail->rel_prods}} --}}
                <div class="col-12">
                    <div class="owl-carousel popular-slider">
                        @foreach($product_detail->rel_prods as $data)
                            @if($data->id !==$product_detail->id)
                                <!-- Début Produit Unique -->
                                <div class="single-product">
                                    <div class="product-img">
                                        <a href="{{route('product-detail',$data->slug)}}">
                                            @php
                                                $photo=explode(',',$data->photo);
                                            @endphp
                                            <img class="default-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                            <img class="hover-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                            <span class="price-dec">{{$data->discount}} % Réduction</span>
                                            {{-- <span class="out-of-stock">Hot</span> --}}
                                        </a>


                                        <div class="button-head">
                                            <div class="product-action">
                                                <a data-toggle="modal" data-target="#modelExample" title="Vue Rapide"
                                                   href="#"><i class=" ti-eye"></i><span>Vue Rapide</span></a>
                                                <a title="Ajouter aux Favoris" href="#"><i class=" ti-heart "></i><span>Ajouter aux Favoris</span></a>
                                            </div>
                                            <div class="product-action-2">
                                                <a title="Ajouter au panier" href="#">Ajouter au panier</a>
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
                                <!-- Fin Produit Unique -->

                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Produits Connexes -->

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
                            <!-- Galerie du Produit -->
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
                            <!-- Fin Galerie du Produit -->
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="quickview-content">
                                <h2>Robe évasée</h2>
                                <div class="quickview-ratting-review">
                                    <div class="quickview-ratting-wrap">
                                        <div class="quickview-ratting">
                                            <i class="yellow fa fa-star"></i>
                                            <i class="yellow fa fa-star"></i>
                                            <i class="yellow fa fa-star"></i>
                                            <i class="yellow fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <a href="#"> (1 avis client)</a>
                                    </div>
                                    <div class="quickview-stock">
                                        <span><i class="fa fa-check-circle-o"></i> en stock</span>
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
                                            <h5 class="title">Taille</h5>
                                            <select>
                                                <option selected="selected">s</option>
                                                <option>m</option>
                                                <option>l</option>
                                                <option>xl</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <h5 class="title">Couleur</h5>
                                            <select>
                                                <option selected="selected">orange</option>
                                                <option>violet</option>
                                                <option>noir</option>
                                                <option>rose</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="quantity">
                                    <!-- Entrée Quantité -->
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
                                    <!--/ Fin Entrée Quantité -->
                                </div>
                                <div class="add-to-cart">
                                    <a href="#" class="btn">Ajouter au panier</a>
                                    <a href="#" class="btn min"><i class="ti-heart"></i></a>
                                    <a href="#" class="btn min"><i class="fa fa-compress"></i></a>
                                </div>
                                <div class="default-social">
                                    <h4 class="share-now">Partager :</h4>
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
        /* Remove Red Line above Dimension */
        .tire-dimension h3 {
            font-size: 2rem;
            font-weight: bold;
            color: #333; /* Keeping it neutral with no red border */
            margin-bottom: 10px; /* Adjust spacing */
            border: none; /* Removed the red line */
        }

        /* Styling for Plus and Minus Buttons */
        .button.minus, .button.plus {

            color: #fff;
            border-radius: 50%;
            border: none;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        /* Disabled state for minus button */
        .button.minus:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        /* Styling for Input Field */
        .input-number {
            width: 60px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin: 0 10px;
            font-size: 1.2rem;
            padding: 5px;
        }

        /* Ensure everything aligns properly */
        .quantity .input-group {
            display: flex;
            align-items: center;
            justify-content: center;
        }


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
