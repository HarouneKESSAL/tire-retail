@extends('frontend.layouts.master')

@section('title', 'E-Shop || Réinitialiser le Mot de Passe')

@section('main-content')
    <!-- Reset Password Form -->
    <section class="shop login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-12">
                    <div class="login-form">
                        <h2>Réinitialiser le Mot de Passe</h2>
                        <!-- Form -->
                        <form class="form" method="post" action="{{ route('password.reset.submit') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <input type="hidden" name="email" value="{{ $email }}">

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>New Password<span>*</span></label>
                                        <input type="password" name="password" placeholder="" required="required">
                                        @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Confirm Password<span>*</span></label>
                                        <input type="password" name="password_confirmation" placeholder="" required="required">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn" type="submit">Reset Password</button>
                                </div>
                            </div>
                        </form>
                        <!--/ End Form -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Reset Password -->
@endsection


@push('styles')
    <style>
        .shop.login .form .btn{
            margin-right:0;
        }
    </style>
@endpush
