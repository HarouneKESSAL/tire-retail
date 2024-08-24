@extends('frontend.layouts.master')

@section('title', __('E-Shop || Reset Password'))

@section('main-content')
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0);"> {{ __('Reset Password') }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="login-form text-center">
                    <h2 class=" display-4  mb-2">
                        {{ __('Reset Password') }}
                        <div class="w-25 mx-auto mt-2" style="border-top: 2px solid #FFA500;"></div>
                    </h2>
                    <p class="login-subtitle text-muted mb-4">
                        {{ __('Please enter your email to reset your password') }}
                    </p>

                    <div class="login-body">
                        @if (session('status'))
                            <div class="alert alert-success mb-4" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}" class="text-left">
                            @csrf

                            <div class="form-group">
                                <label for="email" class="text-gray-700 ">{{ __('Your Email') }} <span class="text-danger">*</span></label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary btn-block font-weight-bold">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </form>
                        <br>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
