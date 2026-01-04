<x-guest-layout>
    @php
    $logo = get_setting('app_logo');
    @endphp

    {{-- Logo & Intro --}}
    <div class="text-center text-primary mb-5">
        <img src="{{ asset('assets/img/logo-2.png') }}" alt="logo" class="maxwidth-200 mx-auto"><br>
        <i class="fs-15 opacity-75 mb-0">
            {{ __('Forgot your password? Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </i>
    </div>

    {{-- Notifikasi Status (Link reset berhasil dikirim) --}}
    @if (session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    {{-- Form Request Reset Password --}}
    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        {{-- Input Email --}}
        <div class="form-floating mb-3">
            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                placeholder="Enter your email" value="{{ old('email') }}" autocomplete="off" required autofocus>

            <label for="email">Email Address</label>

            {{-- Error Validasi --}}
            @error('email')
            <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Button Kirim Link Reset Password --}}
        <button type="submit" class="btn btn-lg btn-primary theme-black w-100">
            Email Password Reset Link
        </button>

        {{-- Back to Login --}}
        <div class="text-center mt-3">
            <a href="{{ route('login') }}" class="text-primary small">
                Back to Login
            </a>
        </div>
    </form>

    <div class="text-center text-primary mb-5">
        {{-- Footer --}}
        <small class="opacity-50 d-block mt-4"> {{ $footer_text }} </small>
    </div>

</x-guest-layout>