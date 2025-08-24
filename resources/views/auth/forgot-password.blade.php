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
     color: red;
     text-shadow: 0 0 2px red;
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
  aspect-ratio: 16/9;" src="https://www.youtube.com/embed/m1VAUq2g0ls?si=HfQOWUbrVSZbTFh6h&autoplay=1&mute=1&controls=0&loop=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>

       </div>
     </div>
     <!-- /Left Text -->

     <!-- Login -->

     <div class="d-flex col-12 col-lg-5 align-items-center p-sm-5 p-4 bg-primary">

       <div class="row">
         <div class="col-md-8 offset-md-2">

           <form method="POST" action="{{ route('password.email') }}">
             @csrf

             <div class="">
               <!-- Logo -->
               <div class="app-brand mb-4">
                 <img src="{{asset('assets/logo/1.jpeg')}}" alt="auth-login-cover" class="w-100" />
               </div>
               <!-- /Logo -->
               <h1 class="mb-1 text-center"><span>Forgot Password?</span></h1>
               <p class="mb-4 text-center">A password reset link will be send to your email</p>

               <div class="mb-3">
                 <label for="email" class="form-label">Email</label>
                 <input type="email" class="form-control" id="email" name="email" :value="old('email')" placeholder="Enter your email" required autofocus />
                 @error('email')=
                 <span class="text-danger">{{$message}}</span>
                 @enderror
               </div>
               <button class="btn btn-dark d-grid w-100 ">{{ __('Email Password Reset Link') }}</button>


           </form>

           <p class="text-center">
             <span>Already have an account?</span>
             <a href="/login" class="text-success">
               <span>Login</span>
             </a>
           </p>



         </div>
       </div>
       <!-- /Login -->


       <!-- Session Status -->
       <x-auth-session-status class="mb-4" :status="session('status')" />


     </div>
   </div>

   @endsection