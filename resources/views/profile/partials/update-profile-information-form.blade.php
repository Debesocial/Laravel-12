<div class="card adminuiux-card mb-4 shadow-sm">
    <div class="card-body">

        {{-- page information header --}}
        <h4 class="fw-bold mb-3">Profile Information</h4>
        <p class="text-secondary small mb-4">
            update your account's profile information and email address
        </p>

        {{-- form for resending verification email (hidden, triggered in backend) --}}
        <form id="send-verification" method="post" action="{{ route('verification.send') }}" style="display:none;">
            @csrf
        </form>
        {{-- update profile form --}}
        <form method="POST" action="{{ route('profile.update') }}" autocomplete="off">

            @csrf
            @method('PATCH')

            {{-- anti autofill trap --}}
            <input type="text" name="fakeuser" style="display:none">
            <input type="password" name="fakepass" style="display:none">

            <div class="row g-3">

                {{-- Name --}}
                <div class="col-12 col-md-6">
                    <label class="form-label fw-semibold">
                        {{ __('Name') }} <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}"
                        placeholder="ex: John Wick" required minlength="3" maxlength="100" pattern="^[a-zA-Z\s]+$"
                        title="Name must be at least 3 characters and contain letters and spaces only">
                </div>

                {{-- Email --}}
                <div class="col-12 col-md-6">
                    <label class="form-label fw-semibold">
                        {{ __('Email') }} <span class="text-danger">*</span>
                    </label>
                    <input type="email" name="email" class="form-control"
                        value="{{ old('email', auth()->user()->email) }}" placeholder="john@email.com" required
                        maxlength="150" title="Enter a valid and unique email address">
                </div>

            </div>

            <button type="submit" class="btn btn-primary mt-3 px-3">
                {{ __('Save Changes') }}
            </button>

        </form>

    </div>
</div>

{{-- sweetalert library --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- sweetalert success - appears when profile is updated successfully --}}
@if (session('status') === 'profile-updated')
<script>
// profile updated successfully
Swal.fire({
    icon: 'success',
    title: 'Profile Updated',
    text: 'Your profile has been successfully updated.',
    showConfirmButton: false,
    timer: 1200
}).then(() => location.reload());
</script>
@endif