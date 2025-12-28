<x-guest-layout>

    {{-- Logo & Halaman Reset Password --}}
    <div class="text-center text-primary mb-5">
        <img src="{{ asset('assets/img/logo-2.png') }}" alt="logo" class="maxwidth-200 mx-auto"><br>
        <p class="opacity-75 fs-6">Enter your new password to reset your account.</p>
    </div>

    {{-- Form Reset Password --}}
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        {{-- Token Reset (dibawa dari email) --}}
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        {{-- Email --}}
        <div class="form-floating mb-3">
            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                placeholder="Email Address" value="{{ old('email', $request->email) }}" required autofocus
                autocomplete="username">

            <label for="email">Email Address</label>

            {{-- Error Validasi --}}
            @error('email')
            <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Password Baru --}}
        <div class="form-floating mb-3">
            <input type="password" id="password" name="password"
                class="form-control @error('password') is-invalid @enderror" placeholder="New Password"
                autocomplete="new-password" required>

            <label for="password">New Password</label>

            {{-- Error Validasi --}}
            @error('password')
            <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Konfirmasi Password Baru --}}
        <div class="form-floating mb-4">
            <input type="password" id="password_confirmation" name="password_confirmation"
                class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirm Password"
                autocomplete="new-password" required>

            <label for="password_confirmation">Confirm Password</label>

            {{-- Error Validasi --}}
            @error('password_confirmation')
            <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Tombol Reset --}}
        <button type="submit" class="btn btn-lg btn-primary theme-black w-100">
            Reset Password
        </button>

        {{-- Redirect ke Login --}}
        <div class="text-center mt-3">
            <a href="{{ route('login') }}" class="text-primary small">Back to Login</a>
        </div>

    </form>

</x-guest-layout>