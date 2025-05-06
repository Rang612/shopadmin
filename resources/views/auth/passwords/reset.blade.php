<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include("partial.auth.head")
<body>
<!-- loader Start -->
<div id="loading">
    <div id="loading-center">
    </div>
</div>
<!-- loader END -->
<!-- Sign in Start -->
<section class="sign-in-page">
    <div class="container sign-in-page-bg mt-5 p-0">
        <div class="row no-gutters">
            <div class="col-md-6 text-center">
                <div class="sign-in-detail text-white">
                    <a class="sign-in-logo mb-5" href="#"><img src="{{ asset('images/logo-white.png') }}" class="img-fluid" alt="logo"></a>
                    <div class="owl-carousel" data-autoplay="true" data-loop="true" data-nav="false" data-dots="true" data-items="1" data-items-laptop="1" data-items-tab="1" data-items-mobile="1" data-items-mobile-sm="1" data-margin="0">
                        <div class="item">
                            <img src="{{asset('images/login/2.png')}}" class="img-fluid mb-4" alt="logo">
                            <h4 class="mb-1 text-white">Welcome back</h4>
                            <p>Welcome back! Keep creating your unique style for your fashion store.</p>
                        </div>
                        <div class="item">
                            <img src="{{asset('images/login/1.png')}}" class="img-fluid mb-4" alt="logo">
                            <h4 class="mb-1 text-white">Manage your items</h4>
                            <p>Managing your store is easy! Log in to start tracking your products, orders, and customers.</p>
                        </div>
                        <div class="item">
                            <img src="{{asset('images/login/3.png')}}" class="img-fluid mb-4" alt="logo">
                            <h4 class="mb-1 text-white">Smart tools</h4>
                            <p>Smart management system helps you optimize your fashion store. Sign in to explore!</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 position-relative">
                 <div class="sign-in-from">
                        <h1 class="mb-0">Reset Password</h1>
                        <p>Enter your email and new password to reset your account</p>

                        <form class="mt-4" method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input id="email" type="email"
                                       class="form-control mb-0 @error('email') is-invalid @enderror"
                                       name="email"
                                       value="{{ $email ?? old('email') }}"
                                       required
                                       autocomplete="email" autofocus>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input id="password" type="password"
                                       class="form-control mb-0 @error('password') is-invalid @enderror"
                                       name="password"
                                       required
                                       autocomplete="new-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password-confirm">Confirm New Password</label>
                                <input id="password-confirm" type="password"
                                       class="form-control mb-0"
                                       name="password_confirmation"
                                       required
                                       autocomplete="new-password">
                            </div>

                            <div class="d-inline-block w-100">
                                <button type="submit" class="btn btn-primary float-right">Reset Password</button>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
</section>
<!-- Sign in END -->
@include("partial.auth.bodyJS")
</body>
</html>

