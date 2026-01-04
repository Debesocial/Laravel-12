<div class="card adminuiux-card mb-4 shadow-sm">
    <div class="card-body">

        {{-- header --}}
        <h4 class="fw-bold mb-3">Update Password</h4>
        <p class="text-secondary small mb-4">Make sure your new password is secure.</p>
        {{-- form update password --}}
        <form method="POST" action="{{ route('password.update') }}" autocomplete="off">

            @csrf
            @method('PUT')

            {{-- anti autofill trap --}}
            <input type="text" name="fakeuser" style="display:none">
            <input type="password" name="fakepass" style="display:none">

            {{-- Current Password --}}
            <div class="mb-3">
                <label for="update_password_current_password" class="form-label fw-semibold">
                    {{ __('Current Password') }} <span class="text-danger">*</span>
                </label>
                <input type="password" id="update_password_current_password" name="current_password"
                    class="form-control" placeholder="Enter current password" required autocomplete="off" minlength="12"
                    title="Enter your current password">
            </div>

            {{-- New Password --}}
            <div class="mb-3">
                <label for="update_password_password" class="form-label fw-semibold">
                    {{ __('New Password') }} <span class="text-danger">*</span>
                </label>
                <input type="password" id="update_password_password" name="password" class="form-control"
                    placeholder="Enter new password" required minlength="12" autocomplete="new-password"
                    pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{12,}$"
                    title="Minimum 12 characters with uppercase, lowercase, number, and symbol">
            </div>

            {{-- Confirm Password --}}
            <div class="mb-3">
                <label for="update_password_password_confirmation" class="form-label fw-semibold">
                    {{ __('Confirm Password') }} <span class="text-danger">*</span>
                </label>
                <input type="password" id="update_password_password_confirmation" name="password_confirmation"
                    class="form-control" placeholder="Confirm new password" required minlength="12"
                    autocomplete="new-password" title="Must match the new password exactly">
            </div>

            {{-- submit --}}
            <div class="d-flex align-items-center gap-3">
                <button type="submit" class="btn btn-primary mt-3 px-3">
                    {{ __('Update Password') }}
                </button>
            </div>

        </form>

    </div>
</div>

{{-- sweetalert2 cdn --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- sweetalert success (trigger setelah update berhasil) --}}
@if (session('status') === 'password-updated')
<script>
// show success alert
Swal.fire({
    icon: 'success',
    title: 'Password Updated',
    text: 'Your password successfully updated.',
    showConfirmButton: false,
    timer: 1200
});
</script>
@endif