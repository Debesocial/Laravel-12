<x-guest-layout>
    <div class="text-center">
        <h1 class="fw-bold fs-2">🚧 Under Maintenance</h1>
        <p class="mt-2 text-secondary">Free Trial is currently unavailable at this time.</p>

        <a href="{{ url()->previous() }}" class="btn btn-dark mt-4 px-5">
            {{ __('Back') }}
        </a>
    </div>
</x-guest-layout>