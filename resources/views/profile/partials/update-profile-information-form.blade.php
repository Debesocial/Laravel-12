<div class="card adminuiux-card mb-4 shadow-sm">
    <div class="card-body">

        {{-- Header Informasi Halaman --}}
        <h4 class="fw-bold mb-3">Profile Information</h4>
        <p class="text-secondary small mb-4">
            Update your account's profile information and email address.
        </p>

        {{-- Form untuk mengirim ulang email verifikasi (disembunyikan, trigger di backend) --}}
        <form id="send-verification" method="post" action="{{ route('verification.send') }}" style="display:none;">
            @csrf
        </form>

        {{-- Form Update Profile --}}
        <form method="post" action="{{ route('profile.update') }}">
            @csrf
            @method('patch')

            <div class="row g-3">

                {{-- Input Name --}}
                <div class="col-12 col-md-6">
                    <label class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', Auth::user()->name) }}" placeholder="Enter your name" required>

                    {{-- Pesan error jika validasi gagal --}}
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Input Email --}}
                <div class="col-12 col-md-6">
                    <label class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', Auth::user()->email) }}" placeholder="Enter your email" required>

                    {{-- Pesan error jika validasi gagal --}}
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <button class="btn btn-primary mt-3 px-3">Save Changes</button>
        </form>
    </div>
</div>

{{-- Library SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- SweetAlert Success - muncul saat profile berhasil diupdate --}}
@if (session('status') === 'profile-updated')
<script>
Swal.fire({
    icon: 'success',
    title: 'Profile Updated',
    text: 'Your profile has been successfully updated.',
    confirmButtonColor: '#1e1e1e', // black solid button
})
</script>
@endif