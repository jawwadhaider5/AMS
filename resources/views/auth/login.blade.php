@extends('backend_app.layouts.auth_template')
@section('content')

<style>
  h1 span {
  transition: 0.5s ease-out;
}
h1:hover span:nth-child(1) {
  margin-right: 5px;
} 
h1:hover span {
  color: blue;
  text-shadow: 0 0 2px blue;
  cursor: pointer;
}

</style>

<div class="authentication-wrapper authentication-cover authentication-bg" style="background: #F1F1F1;">
  <div class="authentication-inner row">
    <!-- /Left Text -->
    <div class="d-none d-lg-flex col-lg-7 p-0 bg-primary">
      <div class="auth-cover-bg  d-flex justify-content-center align-items-center m-0">


        <iframe style="position: absolute;
  z-index: 3;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  mask-image: linear-gradient(to top, transparent 5%, black 50%, transparent 95%);
  user-select: none;
  pointer-events: none;
  filter: grayscale(0.1);
  aspect-ratio: 16/9;" src="https://www.youtube.com/embed/m1VAUq2g0ls?si=HfQOWUbrVSZbTFh6&autoplay=1&mute=1&controls=0&loop=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>

        <!-- <img src="{{asset('assets/logo/1.jpeg')}}" alt="auth-login-cover" class="w-50" />

        <img src="../../assets/img/illustrations/bg-shape-image-light.png" alt="auth-login-cover" class="platform-bg" data-app-light-img="illustrations/bg-shape-image-light.png" data-app-dark-img="illustrations/bg-shape-image-dark.png" /> -->
      </div>
    </div>
    <!-- /Left Text -->

    <!-- Login -->

    <div class="d-flex col-12 col-lg-5 align-items-center p-sm-5 p-4 bg-primary">
      <div class="row">
        <div class="col-md-8 offset-md-2">
          <div class="">
          <form method="POST" action="{{ route('login') }}">
        @csrf

        <div >
          <!-- Logo -->
          <div class="app-brand mb-4">
            <img src="{{asset('assets/logo/1.jpeg')}}" alt="auth-login-cover" class="w-100" />
          </div>
          <!-- /Logo -->
          <h1 class="mb-1 text-center"><span>Welcome to Assets Management System</span></h1>
          <p class="mb-4 text-center">Please sign-in to your account</p>
 
            <div class="mb-3">
              <label for="email" class="form-label tetx-dark">Email or Username</label>
              <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email or username" autofocus />
              @error('email')=
              <span class="text-danger">{{$message}}</span>
              @enderror
            </div>
            <div class="mb-3 form-password-toggle">
              <div class="d-flex justify-content-between">
                <label class="form-label tetx-dark" for="password">Password</label>
                <a href="/forgot-password" class="text-danger">
                  <small>Forgot Password?</small>
                </a>
              </div>
              <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
              </div>
              @error('password')
              <span class="text-danger">{{$message}}</span>
              @enderror
            </div>
            <div class="mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember-me" />
                <label class="form-check-label" for="remember-me"> Remember Me </label>
              </div>
            </div>
            <button class="btn btn-dark d-grid w-100">Sign in</button>

        </div>
      </form>
          </div>
        </div>
      </div>
      
      <!-- /Login -->
    </div>
  </div>

  @endsection