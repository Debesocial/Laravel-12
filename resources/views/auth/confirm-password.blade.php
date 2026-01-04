<x-guest-layout>
    @php
    $logo = get_setting('app_logo');
    @endphp

    {{-- Logo & Intro --}}
    <div class="text-center text-primary mb-5">
        <img src="{{ asset('assets/img/logo-2.png') }}" alt="logo" class="maxwidth-200 mx-auto"><br>
        <p class="opacity-75 fs-6">
            This is a secure area. Please confirm your password to continue.
        </p>
    </div>

    {{-- Form Konfirmasi Password --}}
    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        {{-- Input Password --}}
        <div class="form-floating mb-4">
            <input type="password" id="password" name="password"
                class="form-control @error('password') is-invalid @enderror" placeholder="Password" required
                autocomplete="current-password">

            <label for="password">Password</label>

            {{-- Pesan Error Validasi --}}
            @error('password')
            <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        {{-- Tombol Submit --}}
        <button type="submit" class="btn btn-lg btn-primary theme-black w-100">
            Confirm
        </button>

    </form>

    <div class="text-center text-primary mb-5">
        {{-- Footer --}}
        <small class="opacity-50 d-block mt-4"> {{ $footer_text }} </small>
    </div>
</x-guest-layout>