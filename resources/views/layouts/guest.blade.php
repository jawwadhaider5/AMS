@extends('backend_app.layouts.auth_template')
@section('content')
<div class="authentication-wrapper authentication-cover authentication-bg" style="background: #F1F1F1;">
    <div class="authentication-inner row">
        <!-- /Left Text -->
        <div class="d-none d-lg-flex col-lg-7 p-0">
            <div class="auth-cover-bg  d-flex justify-content-center align-items-center">
                <img src="{{asset('assets/logo/1.jpeg')}}" alt="auth-login-cover" class="w-50" />

                <img src="../../assets/img/illustrations/bg-shape-image-light.png" alt="auth-login-cover" class="platform-bg" data-app-light-img="illustrations/bg-shape-image-light.png" data-app-dark-img="illustrations/bg-shape-image-dark.png" />
            </div>
        </div>

        <div class="d-flex col-12 col-lg-5 align-items-center p-sm-5 p-4">

            <div class="w-px-400">
                <!-- /Logo -->
                <h3 class="mb-1">Welcome Back to Assets Management System!</h3>
                <p class="mb-4">Please Set New Password For Your Account</p>

                {{ $slot }}



            </div>
        </div>
        <!-- /Login -->
    </div>
</div>

@endsection