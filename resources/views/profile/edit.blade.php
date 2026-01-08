<x-app-layout>
    <div class="container-fluid mt-2" id="main-content">
        <div class="row gx-3 gx-lg-4">

            <div class="col-12 col-lg-4">

                {{-- Foto + Summary --}}
                <div class="card adminuiux-card border-0 overflow-hidden mb-3">
                    <div class="text-center position-relative p-3">

                        {{-- Foto avatar utama --}}
                        <div class="avatar avatar-120 rounded-circle border border-3 border-white shadow mt-n5">
                            <img src="assets/img/profile.png" class="rounded-circle">
                        </div>

                        {{-- Nama & role user --}}
                        <h5 class="mt-3 mb-0 fw-bold">{{ Auth::user()->name ?? 'Mobileuxer' }}</h5>
                        <p class="text-secondary small">Admin</p>

                        {{-- Informasi user --}}
                        <div class="text-start mt-3 small">
                            <p><i class="bi bi-envelope me-2"></i> {{ Auth::user()->email }}</p>
                            <p><i class="bi bi-telephone me-2"></i> {{ Auth::user()->phone ?? 'N/A' }}</p>
                            <p><i class="bi bi-cake me-2"></i> {{ Auth::user()->date_of_birth ?? 'N/A' }}</p>
                            <p><i class="bi bi-geo-alt me-2"></i> {{ Auth::user()->city ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Delete Account --}}
                @include('profile.partials.delete-user-form')
            </div>

            <div class="col-12 col-lg-8">

                {{-- Profile Information --}}
                @include('profile.partials.update-profile-information-form')

                {{-- Update Password --}}
                @include('profile.partials.update-password-form')

            </div>
        </div>
    </div>
</x-app-layout>