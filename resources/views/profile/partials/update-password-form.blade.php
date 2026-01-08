<div class="card adminuiux-card mb-4 shadow-sm">
    <div class="card-body">

        {{-- Header --}}
        <h4 class="fw-bold mb-3">Update Password</h4>
        <p class="text-secondary small mb-4">Make sure your new password is secure.</p>

        {{-- Form Update Password --}}
        <form method="post" action="{{ route('password.update') }}">
            @csrf
            @method('put')

            {{-- Current Password --}}
            <div class="mb-3">
                <label for="update_password_current_password" class="form-label">
                    Current Password <span class="text-danger">*</span>
                </label>
                <input type="password" id="update_password_current_password" name="current_password"
                    placeholder="Enter current password"
                    class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                    autocomplete="current-password" required>

                @error('current_password','updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- New Password --}}
            <div class="mb-3">
                <label for="update_password_password" class="form-label">
                    New Password <span class="text-danger">*</span>
                </label>
                <input type="password" id="update_password_password" name="password" placeholder="Enter new password"
                    class="form-control @error('password','updatePassword') is-invalid @enderror"
                    autocomplete="new-password" required>

                @error('password','updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Confirm Password --}}
            <div class="mb-3">
                <label for="update_password_password_confirmation" class="form-label">
                    Confirm Password <span class="text-danger">*</span>
                </label>
                <input type="password" id="update_password_password_confirmation" name="password_confirmation"
                    placeholder="Confirm new password"
                    class="form-control @error('password_confirmation','updatePassword') is-invalid @enderror"
                    autocomplete="new-password" required>

                @error('password_confirmation','updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Submit --}}
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-primary mt-3 px-3">Update Password</button>
            </div>
        </form>
    </div>
</div>

{{-- SweetAlert2 CDN --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- SweetAlert Success (trigger setelah update berhasil) --}}
@if (session('status') === 'password-updated')
<script>
Swal.fire({
    icon: 'success',
    title: 'Password Updated',
    text: 'Your password successfully updated.',
    confirmButtonColor: '#1e1e1e', // black solid button
});
</script>
@endif