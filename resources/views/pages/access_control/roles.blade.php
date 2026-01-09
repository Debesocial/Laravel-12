<x-app-layout>
    <div class="container-fluid mt-2" id="main-content">
        <div class="row gx-3 gx-lg-4"></div>
        <div class="col-12">
            <div class="card adminuiux-card">
                <div class="card-body p-0">

                    {{-- header halaman roles management --}}
                    <div class="p-4 pb-0">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h5 class="mb-0 fw-bold">{{ __('Roles Management') }}</h5>
                                <small class="text-muted">
                                    {{ __('Manage roles, assign permissions, and control access levels within the system.') }}
                                </small>
                            </div>
                            <button class="btn btn-primary mt-3 px-3" data-bs-toggle="modal"
                                data-bs-target="#addRoleModal">
                                &emsp;+ {{ __('Add Role') }}&emsp;
                            </button>
                        </div>
                    </div>

                    {{-- tabel roles --}}
                    <div class="p-4">
                        <div class="table-responsive overflow-hidden">
                            <table id="datatables" class="table table-hover table-bordered w-100 mb-0">
                                <thead>
                                    <tr>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Role Name') }}</th>
                                        <th>{{ __('Guard') }}</th>
                                        <th class="text-wrap">{{ __('Assigned Permissions') }}</th>
                                        <th data-hide="audit">{{ __('Created At') }}</th>
                                        <th data-hide="audit">{{ __('Created By') }}</th>
                                        <th data-hide="audit">{{ __('Last Updated At') }}</th>
                                        <th data-hide="audit">{{ __('Last Updated By') }}</th>
                                        <th class="text-end" width="10%">{{ __('Action') }}</th>
                                    </tr>

                                    {{-- filter bar --}}
                                    <tr class="filter-row">
                                        <th>
                                            <select class="form-select form-select-sm">
                                                <option value="">{{ __('All') }}</option>
                                                <option value="active">{{ __('Active') }}</option>
                                                <option value="inactive">{{ __('Inactive') }}</option>
                                            </select>
                                        </th>
                                        <th><input class="form-control form-control-sm"
                                                placeholder="{{ __('Search Role Name') }}"></th>
                                        <th>
                                            <select class="form-select form-select-sm">
                                                <option value="">{{ __('All') }}</option>
                                                <option value="web">web</option>
                                                <option value="api">api</option>
                                            </select>
                                        </th>
                                        <th><input class="form-control form-control-sm"
                                                placeholder="{{ __('Search Permissions') }}"></th>
                                        <th><input type="date" class="form-control form-control-sm"></th>
                                        <th><input class="form-control form-control-sm"
                                                placeholder="{{ __('Search User') }}"></th>
                                        <th><input type="date" class="form-control form-control-sm"></th>
                                        <th><input class="form-control form-control-sm"
                                                placeholder="{{ __('Search User') }}"></th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($roles as $role)
                                    <tr>
                                        <td>
                                            <div class="form-check form-switch d-flex align-items-center gap-2">
                                                <input class="form-check-input role-toggle" type="checkbox"
                                                    {{ $role->is_active ? 'checked' : '' }} data-id="{{ $role->id }}"
                                                    data-name="{{ $role->name }}">
                                                <span
                                                    class="status-label {{ $role->is_active ? 'text-success' : 'text-danger' }}">
                                                    {{ $role->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </div>
                                        </td>

                                        <td>{{ $role->name }}</td>
                                        <td>{{ $role->guard_name }}</td>
                                        <td>
                                            <div class="permission-clamp" title="{{ $role->permissions->pluck('name')->join(', ') }}">
                                                @forelse ($role->permissions as $permission)
                                                    <span class="badge bg-secondary">{{ $permission->name }}</span>
                                                @empty
                                                    <span>-</span>
                                                @endforelse
                                            </div>
                                        </td>
                                        <td>{{ $role->created_at }}</td>
                                        <td>{{ $role->creator->email ?? 'System' }}</td>
                                        <td>{{ $role->updated_at }}</td>
                                        <td>{{ $role->updater->email ?? '-' }}</td>

                                        <td class="text-end">
                                            {{-- button edit --}}
                                            <button class="btn btn-link btn-edit" data-id="{{ $role->id }}"
                                                data-name="{{ $role->name }}" data-guard="{{ $role->guard_name }}"
                                                data-permissions='@json($role->permissions->pluck("id"))'
                                                data-created="{{ $role->created_at }}"
                                                data-created-by="{{ $role->creator->email ?? 'System' }}"
                                                data-updated-at="{{ $role->updated_at ?? '-' }}"
                                                data-updated-by="{{ $role->updater->email ?? '-' }}"
                                                data-bs-toggle="modal" data-bs-target="#editRoleModal">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            {{-- button delete --}}
                                            <button class="btn btn-link text-danger btn-delete" type="button"
                                                data-id="{{ $role->id }}" data-name="{{ $role->name }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted">
                                            {{ __('No roles found') }}
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- modal tambah role --}}
                    <div class="modal fade" id="addRoleModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-3">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{ __('Add Role') }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form method="POST" action="{{ route('roles.store') }}" autocomplete="off">

                                    @csrf

                                    {{-- anti autofill trap --}}
                                    <input type="text" name="fakeuser" style="display:none">
                                    <input type="password" name="fakepass" style="display:none">

                                    <div class="modal-body">

                                        {{-- Role Name --}}
                                        <label class="form-label fw-semibold">
                                            {{ __('Role Name') }} <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="name" class="form-control mb-3"
                                            placeholder="ex: administrator" required minlength="3" maxlength="50"
                                            pattern="^[a-zA-Z0-9_\-]+$"
                                            title="Minimum 3 characters. Letters, numbers, dash, and underscore only">

                                        {{-- Guard --}}
                                        <label class="form-label fw-semibold">
                                            {{ __('Guard') }} <span class="text-danger">*</span>
                                        </label>
                                        <select name="guard_name" class="form-select mb-3" required
                                            title="Select guard for this role">
                                            <option value="web" selected>web</option>
                                            <option value="api">api</option>
                                        </select>

                                        {{-- Permissions --}}
                                        <label class="form-label fw-semibold">
                                            {{ __('Permissions') }} <span class="text-danger">*</span>
                                        </label>
                                        <select id="permissionsSelect" name="permissions[]" class="form-select" multiple
                                            required title="Select at least one permission">
                                            @foreach ($permissions as $permission)
                                            <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                            @endforeach
                                        </select>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-dark rounded-pill"
                                            data-bs-dismiss="modal">
                                            &emsp;Close&emsp;
                                        </button>
                                        <button type="submit" class="btn btn-dark rounded-pill">
                                            &emsp;Save&emsp;
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- modal edit role --}}
                    <div class="modal fade" id="editRoleModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-3">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{ __('Edit Role') }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form id="editRoleForm" method="POST" autocomplete="off">

                                    @csrf
                                    @method('PUT')

                                    {{-- anti autofill trap --}}
                                    <input type="text" name="fakeuser" style="display:none">
                                    <input type="password" name="fakepass" style="display:none">

                                    <div class="modal-body">

                                        {{-- Role ID (hidden) --}}
                                        <input type="hidden" id="edit-role-id" name="id">

                                        {{-- Role Name --}}
                                        <label class="form-label fw-semibold">
                                            {{ __('Role Name') }} <span class="text-danger">*</span>
                                        </label>
                                        <input id="edit-role-name" name="name" type="text" class="form-control mb-3"
                                            placeholder="{{ __('ex: administrator') }}" required minlength="3"
                                            maxlength="50" pattern="^[a-zA-Z0-9_\-]+$"
                                            title="Minimum 3 characters. Letters, numbers, dash, and underscore only">

                                        {{-- Guard Name --}}
                                        <label class="form-label fw-semibold">
                                            {{ __('Guard') }} <span class="text-danger">*</span>
                                        </label>
                                        <select id="edit-role-guard" name="guard_name" class="form-select mb-3" required
                                            title="Select guard for this role">
                                            <option value="" disabled>{{ __('Select Guard') }}</option>
                                            <option value="web">web</option>
                                            <option value="api">api</option>
                                        </select>

                                        {{-- Permissions --}}
                                        <label class="form-label fw-semibold">
                                            {{ __('Permissions') }} <span class="text-danger">*</span>
                                        </label>
                                        <select id="permissionsSelect2" name="permissions[]" class="form-select"
                                            multiple required title="Select at least one permission">
                                            @foreach ($permissions as $permission)
                                            <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                            @endforeach
                                        </select>

                                        {{-- Audit Log Section --}}
                                        <div class="border rounded p-3 bg-light mt-4">
                                            <h6 class="text-secondary fw-bold mb-3">{{ __('Audit Information') }}</h6>

                                            <label class="form-label text-secondary">{{ __('Created At') }}</label>
                                            <input id="edit-role-created" class="form-control mb-2" readonly>

                                            <label class="form-label text-secondary">{{ __('Created By') }}</label>
                                            <input id="edit-role-created-by" class="form-control mb-2" readonly>

                                            <label class="form-label text-secondary">{{ __('Last Updated At') }}</label>
                                            <input id="edit-role-updated-at" class="form-control mb-2" readonly>

                                            <label class="form-label text-secondary">{{ __('Last Updated By') }}</label>
                                            <input id="edit-role-updated-by" class="form-control" readonly>
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-dark rounded-pill"
                                            data-bs-dismiss="modal">
                                            &emsp;{{ __('Close') }}&emsp;
                                        </button>
                                        <button type="submit" class="btn btn-primary rounded-pill">
                                            &emsp;{{ __('Update') }}&emsp;
                                        </button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>

                    {{-- script handler (status, delete, edit fill data) --}}
                    <script>
                    document.addEventListener("DOMContentLoaded", () => {

                        // init choices for create
                        const permSelect = document.querySelector('#permissionsSelect');
                        if (permSelect && !permSelect.dataset.choices) {
                            new Choices(permSelect, {
                                removeItemButton: true,
                                searchEnabled: true,
                                placeholderValue: 'Select permissions'
                            });
                            permSelect.dataset.choices = "initialized";
                        }

                        // init choices for edit
                        const permSelect2 = document.querySelector('#permissionsSelect2');
                        let editChoices = null;
                        if (permSelect2 && !permSelect2.dataset.choices) {
                            editChoices = new Choices(permSelect2, {
                                removeItemButton: true,
                                searchEnabled: true,
                                placeholderValue: 'Select permissions'
                            });
                            permSelect2.dataset.choices = "initialized";
                        }

                        // toggle status
                        document.querySelectorAll(".role-toggle").forEach(toggle => {
                            toggle.addEventListener("change", () => {
                                const id = toggle.dataset.id;
                                const name = toggle.dataset.name;
                                const status = toggle.checked ? "activate" : "deactivate";
                                const label = toggle.closest(".form-switch").querySelector(
                                    ".status-label");

                                Swal.fire({
                                    title: `${status === "activate" ? "Activate" : "Deactivate"} Role?`,
                                    text: `Are you sure to ${status} "${name}"?`,
                                    icon: "warning",
                                    showCancelButton: true,
                                    confirmButtonColor: "#1e1e1e",
                                    cancelButtonColor: "#ffffff",
                                    confirmButtonText: "Yes",
                                    cancelButtonText: "Cancel",
                                }).then(result => {

                                    // cancel action
                                    if (!result.isConfirmed) {
                                        toggle.checked = !toggle.checked;
                                        return;
                                    }

                                    // request update
                                    fetch("{{ route('roles.toggle-status') }}", {
                                            method: "POST",
                                            headers: {
                                                "Content-Type": "application/json",
                                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                            },
                                            body: JSON.stringify({
                                                id,
                                                status
                                            }),
                                        })
                                        .then(res => res.json())
                                        .then(data => {
                                            if (data.success) {
                                                Swal.fire({
                                                    title: "Success",
                                                    text: "Permission status updated successfully.",
                                                    icon: "success",
                                                    timer: 1200,
                                                    showConfirmButton: false
                                                }).then(() => location.reload());;
                                            } else {
                                                Swal.fire("Error",
                                                    "Failed to update status.",
                                                    "error").then(() => location
                                                    .reload());;
                                                toggle.checked = !toggle.checked;
                                                label.textContent = toggle.checked ?
                                                    "Active" : "Inactive";
                                                label.classList.toggle(
                                                    "text-success", toggle
                                                    .checked);
                                                label.classList.toggle(
                                                    "text-danger", !toggle
                                                    .checked);
                                            }
                                        })
                                        .catch(() => {
                                            Swal.fire("Error", "Server error",
                                                "error");
                                            toggle.checked = !toggle.checked;
                                        });
                                });
                            });
                        });

                        // fill form edit
                        document.querySelectorAll(".btn-edit").forEach(btn => {
                            btn.addEventListener("click", () => {

                                // set form action
                                const url = `{{ route('roles.update', 'ID') }}`.replace("ID",
                                    btn.dataset.id);
                                document.getElementById("editRoleForm").action = url;

                                // basic fields
                                document.getElementById("edit-role-id").value = btn.dataset.id;
                                document.getElementById("edit-role-name").value = btn.dataset
                                    .name;
                                document.getElementById("edit-role-guard").value = btn.dataset
                                    .guard;

                                // set permissions
                                const selected = JSON.parse(btn.dataset.permissions || "[]");
                                if (editChoices) {
                                    editChoices.removeActiveItems();
                                    selected.forEach(value => editChoices.setChoiceByValue(value
                                        .toString()));
                                }

                                // audit fields
                                document.getElementById("edit-role-created").value = btn.dataset
                                    .created;
                                document.getElementById("edit-role-created-by").value = btn
                                    .dataset.createdBy;
                                document.getElementById("edit-role-updated-at").value = btn
                                    .dataset.updatedAt;
                                document.getElementById("edit-role-updated-by").value = btn
                                    .dataset.updatedBy;
                            });
                        });

                        // delete / archive
                        document.querySelectorAll(".btn-delete").forEach(btn => {
                            btn.addEventListener("click", () => {
                                // get role info
                                const id = btn.dataset.id;
                                const name = btn.dataset.name;
                                // confirm
                                Swal.fire({
                                    title: "Archive Role?",
                                    text: `"${name}" will be archived and deactivated.`,
                                    icon: "warning",
                                    showCancelButton: true,
                                    confirmButtonColor: "#dc3545",
                                    cancelButtonColor: "#ffffff",
                                    confirmButtonText: "Yes, Archive",
                                    cancelButtonText: "Cancel",
                                }).then(result => {
                                    // cancel
                                    if (!result.isConfirmed) return;
                                    // build route
                                    const url = "{{ route('roles.destroy', 'ID') }}"
                                        .replace("ID", id);
                                    // request
                                    fetch(url, {
                                            method: "DELETE",
                                            headers: {
                                                "X-CSRF-TOKEN": document
                                                    .querySelector(
                                                        'meta[name="csrf-token"]')
                                                    .content,
                                                "Accept": "application/json",
                                            }
                                        })
                                        .then(res => res.json())
                                        .then(data => {
                                            Swal.fire({
                                                icon: "success",
                                                title: "Archived",
                                                text: data.message ||
                                                    "Role archived successfully.",
                                                timer: 1200,
                                                showConfirmButton: false
                                            }).then(() => location.reload());
                                        })
                                        .catch(() => Swal.fire("Error",
                                            "Server error, please try again.",
                                            "error"));
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