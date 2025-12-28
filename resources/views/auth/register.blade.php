<x-guest-layout>

    {{-- Logo & Tagline --}}
    <div class="text-center text-primary mb-5">
        <img src="{{ asset('assets/img/logo-2.png') }}" alt="logo" class="maxwidth-200 mx-auto"><br>
        <i class="fs-15 opacity-75">
            Start your journey with <b>biiproject.</b>
        </i>
    </div>

    {{-- Session Status (feedback setelah submit) --}}
    @if (session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    {{-- Form Register User Baru --}}
    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- Full Name --}}
        <div class="form-floating mb-3">
            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                placeholder="Full Name" value="{{ old('name') }}" required autocomplete="name" autofocus>

            <label for="name">Full Name</label>

            @error('name')
            <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Email --}}
        <div class="form-floating mb-3">
            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                placeholder="Email Address" value="{{ old('email') }}" autocomplete="off" required>

            <label for="email">Email Address</label>

            @error('email')
            <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Password --}}
        <div class="form-floating mb-3">
            <input type="password" id="password" name="password"
                class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                autocomplete="new-password" required>

            <label for="password">Password</label>

            @error('password')
            <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div class="form-floating mb-4">
            <input type="password" id="password_confirmation" name="password_confirmation"
                class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Confirm Password"
                autocomplete="new-password" required>

            <label for="password_confirmation">Confirm Password</label>

            @error('password_confirmation')
            <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn btn-lg btn-primary theme-black w-100">
            Register
        </button>

        {{-- Redirect ke Login --}}
        <div class="text-center">
            <a href="{{ route('login') }}" class="text-primary small">
                Already registered? Login here
            </a>
        </div>

    </form>

</x-guest-layout>