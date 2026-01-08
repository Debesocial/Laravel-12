<x-guest-layout>

    {{-- Section: Welcome & Intro --}}
    <div class="text-center text-primary mb-5 animate__animated animate__fulsh">

        {{-- Logo --}}
        <img src="{{ asset('assets/img/logo-2.png') }}" alt="logo" class="maxwidth-200 mx-auto mb-3"><br>

        {{-- Headline Intro --}}
        <h1 class="fw-bold" style="font-family: Outfit, sans-serif; font-size: 32px;">
            {{ $app_tagline1 }}
        </h1>

        {{-- Deskripsi Singkat --}}
        <p class="text-muted" style="white-space: pre-line;">
            {{ get_setting('app_tagline2') }}
        </p>

        {{-- CTA (Login & Register) --}}
        <div class="d-flex justify-content-center gap-2 mt-4 mb-4">

            {{-- Login --}}
            <a href="{{ route('login') }}" class="btn btn-lg btn-primary theme-black w-100">
                Login
            </a>

            {{-- Register (Auto-hide jika route register tidak ada) --}}
            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="btn btn-lg btn-outline-dark w-100">
                Register
            </a>
            @endif

            {{-- Trial (Auto-hide jika route tidak ada) --}}
            @if (Route::has('trial'))
            <a href="{{ route('trial') }}" class="btn btn-lg btn-outline-dark w-100">
                Free Trial
            </a>
            @endif

        </div>

        {{-- Footer --}}
        <small class="opacity-50 d-block mt-4"> {{ $footer_text }} </small>
    </div>
</x-guest-layout>