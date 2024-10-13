@extends('frontend.layouts.master')

@section('title','E-SHOP || À Propos de Nous')

@section('main-content')

    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="index1.html">Accueil<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="blog-single.html">À Propos de Nous</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin des Breadcrumbs -->

    <!-- À Propos de Nous -->
    <section class="about-us section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="about-content">
                        @php
                            $settings=DB::table('settings')->get();
                        @endphp
                        <h3>Bienvenue chez <span>Eshop</span></h3>
                        <p>@foreach($settings as $data) {{$data->description}} @endforeach</p>
                        <div class="button">
                            <a href="{{route('blog')}}" class="btn-black">Notre Blog</a>
                            <a href="{{route('contact')}}" class="btn-red">Contactez-Nous</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="about-img overlay">
                        {{-- <div class="button">
                            <a href="https://www.youtube.com/watch?v=nh2aYrGMrIE" class="video video-popup mfp-iframe"><i class="fa fa-play"></i></a>
                        </div> --}}
                        <img src="@foreach($settings as $data) {{$data->photo}} @endforeach" alt="@foreach($settings as $data) {{$data->photo}} @endforeach">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Fin À Propos de Nous -->

    <!-- Début Zone des Services -->
    <section class="shop-services section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Début Service Unique -->
                    <div class="single-service">
                        <i class="ti-rocket"></i>
                        <h4>Livraison Gratuite</h4>
                        <p>Commandes de plus de 100$</p>
                    </div>
                    <!-- Fin Service Unique -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Début Service Unique -->
                    <div class="single-service">
                        <i class="ti-reload"></i>
                        <h4>Retour Gratuit</h4>
                        <p>Retour sous 30 jours</p>
                    </div>
                    <!-- Fin Service Unique -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Début Service Unique -->
                    <div class="single-service">
                        <i class="ti-lock"></i>
                        <h4>Paiement Sécurisé</h4>
                        <p>Paiement 100% sécurisé</p>
                    </div>
                    <!-- Fin Service Unique -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Début Service Unique -->
                    <div class="single-service">
                        <i class="ti-tag"></i>
                        <h4>Meilleur Prix</h4>
                        <p>Prix garanti</p>
                    </div>
                    <!-- Fin Service Unique -->
                </div>
            </div>
        </div>
    </section>
    <!-- Fin Zone des Services -->

    @include('frontend.layouts.newsletter')
@endsection
