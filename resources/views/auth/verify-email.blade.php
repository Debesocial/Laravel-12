<x-guest-layout>

    {{-- Logo & Informasi Halaman --}}
    <div class="text-center text-primary mb-5">
        <img src="{{ asset('assets/img/logo-2.png') }}" alt="logo" class="maxwidth-200 mx-auto"><br>
        <p class="opacity-75 fs-6">
            Thanks for signing up!<br>
            Please verify your email to continue.
        </p>
    </div>

    {{-- Notifikasi: Link verifikasi berhasil dikirim --}}
    @if (session('status') == 'verification-link-sent')
    <div class="alert alert-success text-center mb-4">
        A new verification link has been sent to your email address.
    </div>
    @endif

    {{-- Informasi Panduan --}}
    <div class="text-primary mb-4 text-center">
        <small>
            We have sent you a verification link.
            Didn't receive it? You can request another one below.
        </small>
    </div>

    {{-- Button: Kirim ulang email verifikasi --}}
    <form method="POST" action="{{ route('verification.send') }}" class="mb-3">
        @csrf
        <button type="submit" class="btn btn-lg btn-primary theme-black w-100">
            Resend Verification Email
        </button>
    </form>

    {{-- Aksi Logout --}}
    <form method="POST" action="{{ route('logout') }}" class="text-center">
        @csrf
        <button type="submit" class="btn btn-link text-primary small text-decoration-underline">
            Log Out
        </button>
    </form>

</x-guest-layout>