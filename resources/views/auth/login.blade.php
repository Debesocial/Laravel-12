<x-guest-layout>

    {{-- Logo & Intro --}}
    <div class="text-center text-primary mb-5">
        <img src="{{ asset('assets/img/logo-2.png') }}" alt="logo" class="maxwidth-200 mx-auto"><br>
        <i class="fs-15 opacity-75 mb-0">
            Build, improve, grow — together with <b>biiproject.</b>
        </i>
    </div>

    {{-- Alert Session Status (Login feedback) --}}
    @if (session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    {{-- Login Form --}}
    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email Input --}}
        <div class="form-floating mb-3">
            <input type="email" autocomplete="off" class="form-control @error('email') is-invalid @enderror" id="email"
                name="email" placeholder="Enter email" required value="admin1@example.com">
            {{-- value="{{ old('email') }}" --}}
            <label for="email">Email Address</label>

            {{-- Error Handling --}}
            @error('email')
            <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Password Input --}}
        <div class="form-floating mb-3">
            <input type="password" autocomplete="new-password"
                class="form-control @error('password') is-invalid @enderror" id="password" name="password"
                placeholder="Enter your password" required value="password123">
            <label for="password">Password</label>

            {{-- Error Handling --}}
            @error('password')
            <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Options: Remember + Forgot Password --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <label class="text-primary">
                <input type="checkbox" name="remember"> Remember me
            </label>

            @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="text-primary small">
                Forgot Password?
            </a>
            @endif
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn btn-lg btn-primary theme-black w-100">
            Login
        </button>
    </form>

</x-guest-layout>