    <x-guest-layout>
        @php
        $logo = get_setting('app_logo');
        @endphp

        {{-- Logo & Intro --}}
        <div class="text-center text-primary mb-5">
            <img src="{{ asset('assets/img/logo-2.png') }}" alt="logo" class="maxwidth-200 mx-auto"><br>
            <i class="fs-15 opacity-75 mb-0">
                {{ $app_tagline1 }}<br>
                {{ $app_tagline }}
            </i>
        </div>

        {{-- Alert Session Status (Login feedback) --}}
        @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        @if($errors->has('email'))
        <div class="alert alert-danger mt-2">
            {{ $errors->first('email') }}
        </div>
        @endif

        {{-- Login Form --}}
        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Email Input --}}
            <div class="form-floating mb-3">
                <input type="email" autocomplete="off" class="form-control @error('email') is-invalid @enderror"
                    id="email" name="email" placeholder="Enter email" required value="superadmin@example.com">
                {{-- value="{{ old('email') }}" --}}
                <label for="email">Email Address</label>
            </div>

            {{-- Password Input --}}
            <div class="form-floating mb-3">
                <input type="password" autocomplete="new-password"
                    class="form-control @error('password') is-invalid @enderror" id="password" name="password"
                    placeholder="Enter your password" required value="SAPlogon2010!">
                <label for="password">Password</label>
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
            <button type="submit" class="btn btn-lg btn-primary theme-black w-100 mb-2">
                Login
            </button>
            <a href="{{ route('auth.google') }}" class="btn btn-lg btn-outline-dark w-100">
                <img src="{{ asset('assets/img/google.png') }}" alt="logo" class="maxwidth-20 mx-auto me-2">
                {{ __('Login with Google') }}
            </a>
        </form>

        <div class="text-center text-primary mb-5">
            {{-- Footer --}}
            <small class="opacity-50 d-block mt-4"> {{ $footer_text }} </small>
        </div>

    </x-guest-layout>