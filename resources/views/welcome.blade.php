@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="#" class="h1"><b>Admin</b>LTE</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Silahkan Sign in untuk masuk</p>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email/Username Input -->
                    <div class="input-group mb-3">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            placeholder="NIK" name="name" value="{{ old('name') }}" required autofocus>
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <i class="fas fa-user"></i>
                            </span>
                        </div>
                        @error('name')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Password Input with Eye Icon -->
                    <div class="input-group mb-3">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            placeholder="Password" name="password" required>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-outline-secondary border-0 input-group-text" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="row">
                        <!-- Submit Button -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                    </div>
                </form>
                <hr>
                <!-- Extra Links -->
                <p class="mb-1">
                    <a href="{{ route('password.request') }}">Lupa Password</a>
                </p>
            </div>
        </div>
    </div>


@endsection
@push('scripts')
    <script>
        document.getElementById("togglePassword").addEventListener("click", function() {
            var passwordField = document.getElementById("password");
            var icon = this.querySelector("i");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        });
    </script>
@endpush
