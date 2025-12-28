<div class="card adminuiux-card border-danger shadow-sm mt-4">
    <div class="card-body">

        {{-- Header & Deskripsi --}}
        <h4 class="fw-bold text-danger mb-2">Delete Account</h4>
        <p class="text-secondary small mb-3">
            Once deleted, all your data will be permanently removed. Download any information you want to keep.
        </p>

        {{-- Tombol Trigger SweetAlert Konfirmasi --}}
        <button id="deleteAccountBtn" class="btn btn-danger mt-3 px-3">
            Delete Account
        </button>

        {{-- Form Delete Akun (disubmit setelah konfirmasi SweetAlert) --}}
        <form id="deleteAccountForm" method="post" action="{{ route('profile.destroy') }}" style="display:none;">
            @csrf
            @method('delete')
            <input type="hidden" name="password" id="passwordInput" required>
        </form>
    </div>
</div>

{{-- SweetAlert2 CDN --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById('deleteAccountBtn').addEventListener('click', function(e) {
    e.preventDefault();

    Swal.fire({
        title: 'Are you sure?',
        text: "Once deleted, your account and data will be permanently removed.",
        icon: 'warning',
        input: 'password',
        inputLabel: 'Enter your password to confirm',
        inputPlaceholder: 'Password',
        inputAttributes: {
            required: true
        },
        showCancelButton: true,
        confirmButtonText: 'Delete Account',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        reverseButtons: true,
        preConfirm: (password) => {
            if (!password) Swal.showValidationMessage('Password is required');
            return password;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('passwordInput').value = result.value;
            document.getElementById('deleteAccountForm').submit();
        }
    });
});
</script>

{{-- SweetAlert Error jika password salah (validasi dari server) --}}
@if ($errors->userDeletion->has('password'))
<script>
Swal.fire({
    icon: 'error',
    title: 'Password Incorrect',
    text: '{{ $errors->userDeletion->first("password") }}',
    confirmButtonColor: '#d33'
});
</script>
@endif