<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="mb-2">
            <label for="email">Email Address</label>
            <input id="email" class="form-control" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            
            @error('email')=
              <span class="text-danger">{{$message}}</span>
              @enderror
        </div>

        <!-- Password -->
        <div class="mb-2">
            <label for="password" class="form-label">New Password</label>
            <input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" />
            
            @error('password')=
              <span class="text-danger">{{$message}}</span>
              @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-2">
            <label for="password_confirmation" class="form-label">Confirm Password</label>

            <input id="password_confirmation" class="form-control"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" /> 
            @error('password_confirmation')=
              <span class="text-danger">{{$message}}</span>
              @enderror
        </div>
        <button class="btn btn-primary d-grid w-100">Reset Password</button>
    </form>
</x-guest-layout>
