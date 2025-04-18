@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="cold-md-8 col-lg-5">
            <div class="card">
                <div class="card-body">
                    <center>
                        <img class="denlee-logo" src="/images/Icon-App-40x40@1x.png" alt="">
                    </center>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-denlee">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    .denlee-logo {
        height: auto;
        width: 8vw;
        margin-left: 2vw;
        margin-bottom: 5vh;
    }

    .card {
        margin-top: 25vh;
    }
    
    .btn-denlee {
        background-color: #218c74 !important;
        color: white !important; 
    }

    .theme--light.v-application {
        background-image: url("images/318624696_612907163936517_3734310914409450691_n.jpg") !important;
        background-size: cover !important;
        background-repeat: no-repeat !important;
        background-position: center center !important;
    }
</style>
