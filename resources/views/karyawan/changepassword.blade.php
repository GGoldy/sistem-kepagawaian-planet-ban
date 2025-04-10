@extends('layouts.admin')

@section('title', 'Mengatur Ulang Password')

@section('content')
    <div class="container">
        <h1 class="text-center my-4">{{ $pageTitle }}</h1>

        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6"> {{-- Wider than default --}}
                <div class="card card-primary shadow-lg">
                    <div class="card-header">
                        <h3 class="card-title mb-0">{{ __('Mengatur Ulang Password') }}</h3>
                    </div>

                    <div class="card-body">
                        <form method="POST"
                            action="{{ route('karyawans.updatepassword', ['id' => Auth::user()->karyawan->id]) }}">
                            @csrf
                            @method('put')

                            <div class="form-group">
                                <label for="previous_password">{{ __('Password Sebelumnya') }}</label>
                                <div class="input-group">
                                    <input id="previous_password" type="password"
                                        class="form-control @error('previous_password') is-invalid @enderror"
                                        name="previous_password" value="{{ old('previous_password') }}" required autofocus>
                                    <div class="input-group-append">
                                        <span class="input-group-text toggle-password" data-target="#previous_password">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                                @error('previous_pass')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="new_password">{{ __('Password Baru') }}</label>
                                <div class="input-group">
                                    <input id="new_password" type="password"
                                        class="form-control @error('new_password') is-invalid @enderror" name="new_password"
                                        required>
                                    <div class="input-group-append">
                                        <span class="input-group-text toggle-password" data-target="#new_password">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                                @error('new_password')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="confirm_password">{{ __('Konfirmasi Password Baru') }}</label>
                                <div class="input-group">
                                    <input id="confirm_password" type="password" class="form-control"
                                        name="confirm_password" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text toggle-password" data-target="#confirm_password">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                                @error('confirm_password')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <p class="mb-0">
                                    <a href="{{ route('password.request') }}">Lupa Password</a>
                                </p>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-key mr-1"></i> {{ __('Reset Password') }}
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).on('click', '.toggle-password', function() {
            const input = $($(this).data('target'));
            const icon = $(this).find('i');
            const type = input.attr('type') === 'password' ? 'text' : 'password';

            input.attr('type', type);
            icon.toggleClass('fa-eye fa-eye-slash');
        });
    </script>
@endpush
