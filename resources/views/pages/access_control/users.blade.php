<x-app-layout>
    <div class="container-fluid mt-2" id="main-content">
        <div class="row gx-3 gx-lg-4"></div>
        <div class="col-12">
            <div class="card adminuiux-card">
                <div class="card-body p-0">

                    {{-- header halaman user management --}}
                    <div class="p-4 pb-0">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h5 class="mb-0 fw-bold">{{ __('User Management') }}</h5>
                                <small class="text-muted">
                                    {{ __('Manage users, assign roles, and control access within the system.') }}
                                </small>
                            </div>
                            @can('manage users')
                            <button class="btn btn-primary mt-3 px-3" data-bs-toggle="modal"
                                data-bs-target="#addUserModal">
                                &emsp;+ {{ __('Add User') }}&emsp;
                            </button>
                            @endcan
                        </div>
                    </div>

                    {{-- tabel users --}}
                    <div class="p-4">
                        <div class="table-responsive overflow-hidden">
                            <table id="datatables" class="table table-hover table-bordered w-100 nowrap mb-0">
                                <thead>
                                    <tr>
                                        @can('manage users')
                                        <th class="text-wrap">{{ __('Status') }}</th>
                                        @endcan
                                        <th class="text-wrap">{{ __('User Name') }}</th>
                                        <th class="text-wrap">{{ __('Email') }}</th>
                                        <th class="text-wrap">{{ __('Roles') }}</th>
                                        <th class="text-wrap" data-hide="audit">{{ __('Created At') }}</th>
                                        <th class="text-wrap" data-hide="audit">{{ __('Created By') }}</th>
                                        <th class="text-wrap" data-hide="audit">{{ __('Last Updated At') }}</th>
                                        <th class="text-wrap" data-hide="audit">{{ __('Last Updated By') }}</th>
                                        @can('manage users')
                                        <th class="text-wrap text-end">{{ __('Action') }}</th>
                                        @endcan
                                    </tr>

                                    {{-- filter --}}
                                    <tr class="filter-row">
                                        @can('manage users')
                                        <th>
                                            <select class="form-select form-select-sm">
                                                <option value="">{{ __('All') }}</option>
                                                <option value="active">{{ __('Active') }}</option>
                                                <option value="inactive">{{ __('Inactive') }}</option>
                                            </select>
                                        </th>
                                        @endcan
                                        <th><input class="form-control form-control-sm"
                                                placeholder="{{ __('Search Name') }}"></th>
                                        <th><input class="form-control form-control-sm"
                                                placeholder="{{ __('Search Email') }}"></th>
                                        <th><input class="form-control form-control-sm"
                                                placeholder="{{ __('Search Role') }}"></th>
                                        <th><input type="date" class="form-control form-control-sm"></th>
                                        <th><input class="form-control form-control-sm"
                                                placeholder="{{ __('Created By') }}"></th>
                                        <th><input type="date" class="form-control form-control-sm"></th>
                                        <th><input class="form-control form-control-sm"
                                                placeholder="{{ __('Updated By') }}"></th>
                                        @can('manage users')
                                        <th></th>
                                        @endcan
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($users as $user)
                                    @if ( auth()->user()->hasRole('superadmin') || ! $user->hasRole('superadmin') ) <tr>
                                        {{-- toggle status --}}
                                        @can('manage users')
                                        <td>
                                            <div class="form-check form-switch d-flex align-items-center gap-2">
                                                <input class="form-check-input user-toggle" type="checkbox"
                                                    {{ $user->is_active ? 'checked' : '' }} data-id="{{ $user->id }}"
                                                    data-name="{{ $user->name }}">
                                                <span
                                                    class="status-label {{ $user->is_active ? 'text-success' : 'text-danger' }}">
                                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </div>
                                        </td>
                                        @endcan

                                        {{-- tabel data --}}
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @foreach ($user->roles as $role)
                                            <span class="badge bg-secondary">{{ $role->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>{{ $user->created_at }}</td>
                                        <td>{{ $user->creator->email ?? 'System' }}</td>
                                        <td>{{ $user->updated_at }}</td>
                                        <td>{{ $user->updater->email ?? '-' }}</td>

                                        @can('manage users')
                                        {{-- ACTION --}}
                                        <td class="text-end">
                                            <div class="d-inline-flex align-items-center gap-2">
                                                {{-- IMPERSONATE (SUPER ADMIN ONLY) --}}
                                                @role('superadmin')
                                                @if(auth()->id() !== $user->id && ! $user->hasRole('superadmin'))
                                                <form method="POST" action="{{ route('impersonate.start', $user->id) }}"
                                                    class="d-inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="btn btn-warning btn-sm rounded-pill px-3">
                                                        {{ __('Impersonate') }}
                                                    </button>
                                                </form>
                                                @endif
                                                @endrole

                                                {{-- Edit --}}
                                                <button class="btn btn-link btn-edit" data-id="{{ $user->id }}"
                                                    data-name="{{ $user->name }}" data-email="{{ $user->email }}"
                                                    data-roles='@json($user->roles->pluck("id")->toArray())'
                                                    data-created="{{ $user->created_at }}"
                                                    data-created-by="{{ $user->creator->email ?? 'System' }}"
                                                    data-updated-at="{{ $user->updated_at ?? '-' }}"
                                                    data-updated-by="{{ $user->updater->email ?? '-' }}"
                                                    data-bs-toggle="modal" data-bs-target="#editUserModal">
                                                    <i class="bi bi-pencil"></i>
                                                </button>

                                                {{-- Delete/Archive --}}
                                                <button class="btn btn-link text-danger btn-delete"
                                                    data-id="{{ $user->id }}" data-name="{{ $user->name }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                        @endcan
                                    </tr>
                                    @endif
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted">
                                            {{ __('No users found') }}
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- MODAL ADD USER --}}
                    <div class="modal fade" id="addUserModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-3">

                                <div class="modal-header">
                                    <h5 class="modal-title">{{ __('Add User') }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form method="POST" action="{{ route('users.store') }}" autocomplete="off">

                                    @csrf

                                    {{-- anti autofill trap --}}
                                    <input type="text" name="fakeuser" style="display:none">
                                    <input type="password" name="fakepass" style="display:none">

                                    <div class="modal-body">

                                        {{-- User Name --}}
                                        <label class="form-label fw-semibold">
                                            {{ __('User Name') }} <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="name" class="form-control mb-3"
                                            placeholder="ex: John Wick" required minlength="3" maxlength="100"
                                            pattern="^[a-zA-Z\s]+$"
                                            title="Name must be at least 3 characters and contain letters and spaces only">

                                        {{-- Email --}}
                                        <label class="form-label fw-semibold">
                                            {{ __('Email') }} <span class="text-danger">*</span>
                                        </label>
                                        <input type="email" name="email" class="form-control mb-3"
                                            placeholder="john@email.com" required maxlength="150"
                                            title="Enter a valid and unique email address">

                                        {{-- Password --}}
                                        <label class="form-label fw-semibold">
                                            {{ __('Password') }} <span class="text-danger">*</span>
                                        </label>
                                        <input type="password" name="password" class="form-control mb-3"
                                            placeholder="Minimum 12 characters" required minlength="12"
                                            autocomplete="new-password"
                                            pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{12,}$"
                                            title="Minimum 12 characters with uppercase, lowercase, number, and symbol">

                                        {{-- Assign Role --}}
                                        <label class="form-label fw-semibold">
                                            {{ __('Assign Role') }} <span class="text-danger">*</span>
                                        </label>
                                        <select id="roleSelect" name="roles[]" class="form-select" multiple required
                                            title="Select at least one role">
                                            @foreach ($roles as $role)
                                            @if($role->name !== 'superadmin' || auth()->user()->hasRole('superadmin'))
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endif
                                            @endforeach
                                        </select>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-dark rounded-pill"
                                            data-bs-dismiss="modal">
                                            &emsp;Close&emsp;
                                        </button>
                                        <button type="submit" class="btn btn-dark rounded-pill">
                                            &emsp;Save User&emsp;
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- MODAL EDIT USER --}}
                    <div class="modal fade" id="editUserModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-3">

                                <div class="modal-header">
                                    <h5 class="modal-title">{{ __('Edit User') }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form id="editUserForm" method="POST" autocomplete="off">

                                    @csrf
                                    @method('PUT')

                                    {{-- anti autofill trap --}}
                                    <input type="text" name="fakeuser" style="display:none">
                                    <input type="password" name="fakepass" style="display:none">

                                    <div class="modal-body">

                                        <input type="hidden" id="edit-user-id" name="id">

                                        {{-- User Name --}}
                                        <label class="form-label fw-semibold">
                                            {{ __('User Name') }} <span class="text-danger">*</span>
                                        </label>
                                        <input id="edit-user-name" name="name" type="text" class="form-control mb-3"
                                            placeholder="ex: John Wick" required minlength="3" maxlength="100"
                                            pattern="^[a-zA-Z\s]+$"
                                            title="Name must be at least 3 characters and contain letters and spaces only">

                                        {{-- Email --}}
                                        <label class="form-label fw-semibold">
                                            {{ __('Email') }} <span class="text-danger">*</span>
                                        </label>
                                        <input id="edit-user-email" name="email" type="email" class="form-control mb-3"
                                            placeholder="john@email.com" required maxlength="150"
                                            title="Enter a valid and unique email address">

                                        {{-- Password (Optional) --}}
                                        <label class="form-label fw-semibold">
                                            {{ __('Password (Optional)') }}
                                        </label>
                                        <input name="password" type="password" class="form-control mb-3"
                                            placeholder="leave empty to keep current" minlength="12"
                                            autocomplete="new-password"
                                            pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{12,}$"
                                            title="Minimum 12 characters with uppercase, lowercase, number, and symbol">

                                        {{-- Roles --}}
                                        <label class="form-label fw-semibold">
                                            {{ __('Roles') }} <span class="text-danger">*</span>
                                        </label>
                                        <select id="roleSelect2" name="roles[]" class="form-select" multiple required
                                            title="Select at least one role">
                                            @foreach ($roles as $role)
                                            @if($role->name !== 'superadmin' || auth()->user()->hasRole('superadmin'))
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endif
                                            @endforeach
                                        </select>

                                        {{-- audit --}}
                                        <div class="border rounded p-3 bg-light mt-4">
                                            <h6 class="text-secondary fw-bold mb-3">{{ __('Audit Information') }}</h6>

                                            <label class="form-label text-secondary">{{ __('Created At') }}</label>
                                            <input id="edit-user-created" class="form-control mb-2" readonly>

                                            <label class="form-label text-secondary">{{ __('Created By') }}</label>
                                            <input id="edit-user-created-by" class="form-control mb-2" readonly>

                                            <label class="form-label text-secondary">{{ __('Last Updated At') }}</label>
                                            <input id="edit-user-updated-at" class="form-control mb-2" readonly>

                                            <label class="form-label text-secondary">{{ __('Last Updated By') }}</label>
                                            <input id="edit-user-updated-by" class="form-control" readonly>
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-dark rounded-pill"
                                            data-bs-dismiss="modal">
                                            &emsp;Close&emsp;
                                        </button>
                                        <button type="submit" class="btn btn-primary rounded-pill">
                                            &emsp;Update User&emsp;
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- SCRIPT HANDLER --}}
                    <script>
                    document.addEventListener("DOMContentLoaded", () => {

                        // init choices create
                        const roleSelect = document.querySelector('#roleSelect');
                        if (roleSelect && !roleSelect.dataset.choices) {
                            new Choices(roleSelect, {
                                removeItemButton: true,
                                searchEnabled: true,
                                placeholderValue: 'Select roles'
                            });
                            roleSelect.dataset.choices = "initialized";
                        }

                        // init choices edit
                        const roleSelect2 = document.querySelector('#roleSelect2');
                        let editChoices = null;
                        if (roleSelect2 && !roleSelect2.dataset.choices) {
                            editChoices = new Choices(roleSelect2, {
                                removeItemButton: true,
                                searchEnabled: true,
                                placeholderValue: 'Select roles'
                            });
                            roleSelect2.dataset.choices = "initialized";
                        }

                        // status toggle
                        document.querySelectorAll(".user-toggle").forEach(toggle => {
                            toggle.addEventListener("change", () => {
                                const id = toggle.dataset.id;
                                const name = toggle.dataset.name;
                                const status = toggle.checked ? "activate" : "deactivate";
                                const label = toggle.closest(".form-switch").querySelector(
                                    ".status-label");

                                Swal.fire({
                                    title: `${status === "activate" ? "Activate" : "Deactivate"} User?`,
                                    text: `Are you sure to ${status} "${name}"?`,
                                    icon: "warning",
                                    showCancelButton: true,
                                    confirmButtonColor: "#1e1e1e",
                                    confirmButtonText: "Yes",
                                    cancelButtonText: "Cancel",
                                }).then(result => {
                                    if (!result.isConfirmed) {
                                        toggle.checked = !toggle.checked;
                                        return;
                                    }

                                    label.textContent = toggle.checked ? "Active" :
                                        "Inactive";
                                    label.classList.toggle("text-success", toggle
                                        .checked);
                                    label.classList.toggle("text-danger", !toggle
                                        .checked);

                                    fetch("{{ route('users.toggle-status') }}", {
                                            method: "POST",
                                            headers: {
                                                "Content-Type": "application/json",
                                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                            },
                                            body: JSON.stringify({
                                                id,
                                                status
                                            }),
                                        }).then(res => res.json())
                                        .then(data => {
                                            if (!data.success) {
                                                Swal.fire("Error",
                                                    "Failed to update status.",
                                                    "error");
                                                toggle.checked = !toggle.checked;
                                            }
                                        });
                                });
                            });
                        });

                        // fill edit modal
                        document.querySelectorAll(".btn-edit").forEach(btn => {
                            btn.addEventListener("click", () => {

                                const url = `{{ route('users.update', 'ID') }}`.replace("ID",
                                    btn.dataset.id);
                                document.getElementById("editUserForm").action = url;

                                document.getElementById("edit-user-id").value = btn.dataset.id;
                                document.getElementById("edit-user-name").value = btn.dataset
                                    .name;
                                document.getElementById("edit-user-email").value = btn.dataset
                                    .email;

                                // roles
                                const selected = JSON.parse(btn.dataset.roles || "[]");
                                if (editChoices) {
                                    editChoices.removeActiveItems();
                                    selected.forEach(role => editChoices.setChoiceByValue(role
                                        .toString()));
                                }

                                // audit
                                document.getElementById("edit-user-created").value = btn.dataset
                                    .created;
                                document.getElementById("edit-user-created-by").value = btn
                                    .dataset.createdBy;
                                document.getElementById("edit-user-updated-at").value = btn
                                    .dataset.updatedAt;
                                document.getElementById("edit-user-updated-by").value = btn
                                    .dataset.updatedBy;
                            });
                        });

                        // delete
                        document.querySelectorAll(".btn-delete").forEach(btn => {
                            btn.addEventListener("click", () => {
                                const id = btn.dataset.id;
                                const name = btn.dataset.name;

                                Swal.fire({
                                    title: "Archive User?",
                                    text: `"${name}" will be archived and deactivated.`,
                                    icon: "warning",
                                    showCancelButton: true,
                                    confirmButtonColor: "#dc3545",
                                    confirmButtonText: "Yes, Archive",
                                }).then(result => {
                                    if (!result.isConfirmed) return;

                                    const url = `{{ route('users.destroy', 'ID') }}`
                                        .replace("ID", id);

                                    fetch(url, {
                                            method: "DELETE",
                                            headers: {
                                                "X-CSRF-TOKEN": document
                                                    .querySelector(
                                                        'meta[name="csrf-token"]')
                                                    .content,
                                                "Accept": "application/json",
                                            }
                                        }).then(res => res.json())
                                        .then(data => {
                                            Swal.fire({
                                                icon: "success",
                                                title: "Archived",
                                                text: data.message,
                                                timer: 1200,
                                                showConfirmButton: false
                                            }).then(() => location.reload());
                                        });
                                });
                            });
                        });

                    });
                    </script>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>