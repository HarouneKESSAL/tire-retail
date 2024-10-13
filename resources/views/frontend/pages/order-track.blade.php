@extends('frontend.layouts.master')

@section('title','E-SHOP || Suivi de Commande')

@section('main-content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{route('home')}}">Accueil<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0);">Suivi de Commande</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <section class="tracking_box_area section_gap py-5">
        <div class="container">
            <div class="tracking_box_inner">
                <p>Pour suivre votre commande, veuillez entrer votre numéro de commande dans la case ci-dessous et appuyer sur le bouton "Suivre". Ce numéro vous a été donné sur votre reçu et dans l'email de confirmation que vous avez dû recevoir.</p>
                <form class="row tracking_form my-4" action="{{route('product.track.order')}}" method="post" novalidate="novalidate">
                    @csrf
                    <div class="col-md-8 form-group">
                        <input type="text" class="form-control p-2" name="order_number" placeholder="Entrez votre numéro de commande">
                    </div>
                    <div class="col-md-8 form-group">
                        <button type="submit" value="submit" class="btn submit_btn">Suivre la Commande</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
