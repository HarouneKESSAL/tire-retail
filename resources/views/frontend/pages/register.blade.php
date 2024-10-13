@extends('frontend.layouts.master')

@section('title','E-SHOP || Page d\'inscription')

@section('main-content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{ route('home') }}">Accueil<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0);">Inscription</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin des Breadcrumbs -->

    <!-- Afficher le message de succès -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Afficher les erreurs de validation -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Inscription Boutique -->
    <section class="shop login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-12">
                    <div class="login-form">
                        <h2>Inscription</h2>
                        <p>Veuillez vous inscrire pour finaliser vos achats plus rapidement</p>
                        <!-- Formulaire -->
                        <form class="form" method="post" action="{{ route('register.submit') }}">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Votre nom<span>*</span></label>
                                        <input type="text" name="name" placeholder="" required="required" value="{{ old('name') }}">
                                        @error('name')
                                        <span class="text-danger">{{ $error->first('name') }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Votre email<span>*</span></label>
                                        <input type="email" name="email" placeholder="" required="required" value="{{ old('email') }}">
                                        @error('email')
                                        <span class="text-danger">{{ $error->first('email') }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Votre mot de passe<span>*</span></label>
                                        <input type="password" name="password" placeholder="" required="required">
                                        @error('password')
                                        <span class="text-danger">{{ $error->first('password') }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Confirmer le mot de passe<span>*</span></label>
                                        <input type="password" name="password_confirmation" placeholder="" required="required">
                                        @error('password_confirmation')
                                        <span class="text-danger">{{ $error->first('password_confirmation') }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group login-btn" style="display: flex; justify-content: center; gap: 10px;">
                                        <button class="btn-red" type="submit">S'inscrire</button>
                                        <a href="{{ route('login.form') }}" class="btn-black">Se connecter</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!--/ Fin du formulaire -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ Fin Inscription -->
@endsection

@push('styles')
    <style>
        .shop.login .form .btn {
            margin-right: 0;
        }
    </style>
@endpush
