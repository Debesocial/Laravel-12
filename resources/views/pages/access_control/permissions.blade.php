<x-app-layout>
    <div class="container-fluid mt-2" id="main-content">
        <div class="row gx-3 gx-lg-4"></div>
        <div class="col-12">
            <div class="card adminuiux-card">
                <div class="card-body p-0">

                    {{-- header halaman permission management --}}
                    <div class="p-4 pb-0">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h5 class="mb-0 fw-bold">{{ __('Permission Management') }}</h5>
                                <small class="text-muted">
                                    {{ __('Manage permissions, define access rules, and control user capabilities within the system.') }}
                                </small>
                            </div>
                            <button class="btn btn-primary mt-3 px-3" data-bs-toggle="modal"
                                data-bs-target="#addPermissionModal">
                                &emsp;+ {{ __('Add Permission') }}&emsp;
                            </button>
                        </div>
                    </div>

                    {{-- tabel permission --}}
                    <div class="p-4">
                        <div class="table-responsive overflow-hidden">
                            <table id="datatables" class="table table-hover table-bordered w-100 nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-wrap">{{ __('Status') }}</th>
                                        <th class="text-wrap">{{ __('Permission Name') }}</th>
                                        <th class="text-wrap">{{ __('Module / Guard') }}</th>
                                        <th class="text-wrap">{{ __('Assigned To (Roles)') }}</th>
                                        <th class="text-wrap" data-hide="audit">{{ __('Created At') }}</th>
                                        <th class="text-wrap" data-hide="audit">{{ __('Created By') }}</th>
                                        <th class="text-wrap" data-hide="audit">{{ __('Last Updated At') }}</th>
                                        <th class="text-wrap" data-hide="audit">{{ __('Last Updated By') }}</th>
                                        <th class="text-end text-wrap">{{ __('Action') }}</th>
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
                                                placeholder="{{ __('Search Permission Name') }}"></th>
                                        <th>
                                            <select class="form-select form-select-sm">
                                                <option value="">{{ __('All') }}</option>
                                                <option value="web">web</option>
                                                <option value="api">api</option>
                                            </select>
                                        </th>
                                        <th><input class="form-control form-control-sm"
                                                placeholder="{{ __('Search Assigned Roles') }}"></th>
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
                                    @forelse ($permissions as $permission)
                                    <tr>
                                        <td>
                                            <div class="form-check form-switch d-flex align-items-center gap-2">
                                                <input class="form-check-input permission-toggle" type="checkbox"
                                                    {{ $permission->is_active ? 'checked' : '' }}
                                                    data-id="{{ $permission->id }}" data-name="{{ $permission->name }}">
                                                <span
                                                    class="status-label {{ $permission->is_active ? 'text-success' : 'text-danger' }}">
                                                    {{ $permission->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>{{ $permission->name }}</td>
                                        <td>{{ $permission->guard_name }}</td>
                                        <td>
                                            {{ $permission->roles->pluck('name')->implode(', ') ?: '-' }}
                                        </td>
                                        <td data-hide="audit">{{ $permission->created_at }}</td>
                                        <td data-hide="audit">{{ $permission->creator->email ?? 'System' }}</td>
                                        <td data-hide="audit">{{ $permission->updated_at }}</td>
                                        <td data-hide="audit">{{ $permission->updater->email ?? '-' }}</td>
                                        <td class="text-end">
                                            {{-- button edit --}}
                                            <button class="btn btn-link btn-edit" data-id="{{ $permission->id }}"
                                                data-name="{{ $permission->name }}"
                                                data-guard="{{ $permission->guard_name }}"
                                                data-created="{{ $permission->created_at }}"
                                                data-created-by="{{ $permission->creator->email ?? 'System' }}"
                                                data-updated-at="{{ $permission->updated_at ?? '-' }}"
                                                data-updated-by="{{ $permission->updater->email ?? '-' }}"
                                                data-bs-toggle="modal" data-bs-target="#editPermissionModal">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-link text-danger btn-delete"
                                                data-id="{{ $permission->id }}" data-name="{{ $permission->name }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted">
                                            {{ __('Belum ada permission') }}
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- modal tambah permission --}}
                    <div class="modal fade" id="addPermissionModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-3">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{ __('Add Permission') }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form method="POST" action="{{ route('permissions.store') }}" autocomplete="off">

                                    @csrf

                                    {{-- anti autofill trap --}}
                                    <input type="text" name="fakeuser" style="display:none">
                                    <input type="password" name="fakepass" style="display:none">

                                    <div class="modal-body">

                                        {{-- Permission Name --}}
                                        <label class="form-label fw-semibold">
                                            {{ __('Permission Name') }} <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="name" class="form-control mb-3"
                                            placeholder="ex: view_report / edit_data" required minlength="3"
                                            maxlength="100" pattern="^[a-zA-Z0-9_\-\.\/]+$"
                                            title="Minimum 3 characters. Allowed: letters, numbers, dash, underscore, dot, and slash">

                                        {{-- Module / Guard --}}
                                        <label class="form-label fw-semibold">
                                            {{ __('Module / Guard') }} <span class="text-danger">*</span>
                                        </label>
                                        <select name="guard_name" class="form-select mb-3" required
                                            title="Select guard for this permission">
                                            <option value="web" selected>web</option>
                                            <option value="api">api</option>
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

                    {{-- modal edit permission --}}
                    <div class="modal fade" id="editPermissionModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-3">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{ __('Edit Permission') }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form id="editPermissionForm" method="POST" autocomplete="off">

                                    @csrf
                                    @method('PUT')

                                    {{-- anti autofill trap --}}
                                    <input type="text" name="fakeuser" style="display:none">
                                    <input type="password" name="fakepass" style="display:none">

                                    <div class="modal-body">

                                        {{-- hidden id --}}
                                        <input type="hidden" id="edit-permission-id" name="id">

                                        {{-- Permission Name --}}
                                        <label class="form-label fw-semibold">
                                            {{ __('Permission Name') }} <span class="text-danger">*</span>
                                        </label>
                                        <input id="edit-permission-name" name="name" type="text"
                                            class="form-control mb-3" placeholder="ex: view_report / edit_data" required
                                            minlength="3" maxlength="100" pattern="^[a-zA-Z0-9_\-\.\/]+$"
                                            title="Minimum 3 characters. Allowed: letters, numbers, dash, underscore, dot, and slash">

                                        {{-- Module / Guard --}}
                                        <label class="form-label fw-semibold">
                                            {{ __('Module / Guard') }} <span class="text-danger">*</span>
                                        </label>
                                        <select id="edit-permission-guard" name="guard_name" class="form-select mb-3"
                                            required title="Select guard for this permission">
                                            <option value="web">web</option>
                                            <option value="api">api</option>
                                        </select>

                                        {{-- audit log --}}
                                        <div class="border rounded p-3 bg-light mt-4">
                                            <h6 class="text-secondary fw-bold mb-3">{{ __('Audit Information') }}</h6>

                                            <label class="form-label text-secondary">{{ __('Created At') }}</label>
                                            <input id="edit-permission-created" class="form-control mb-2" readonly>

                                            <label class="form-label text-secondary">{{ __('Created By') }}</label>
                                            <input id="edit-permission-created-by" class="form-control mb-2" readonly>

                                            <label class="form-label text-secondary">{{ __('Last Updated At') }}</label>
                                            <input id="edit-permission-updated-at" class="form-control mb-2" readonly>

                                            <label class="form-label text-secondary">{{ __('Last Updated By') }}</label>
                                            <input id="edit-permission-updated-by" class="form-control" readonly>
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-dark rounded-pill"
                                            data-bs-dismiss="modal">
                                            &emsp;Close&emsp;
                                        </button>
                                        <button type="submit" class="btn btn-primary rounded-pill">
                                            &emsp;Update&emsp;
                                        </button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>

                    {{-- script handler (status, delete, edit fill data) --}}
                    <script>
                    document.addEventListener("DOMContentLoaded", () => {

                        // =========================
                        // TOGGLE STATUS (SERVER-DRIVEN)
                        // =========================
                        document.querySelectorAll(".permission-toggle").forEach(toggle => {
                            toggle.addEventListener("change", () => {

                                const id = toggle.dataset.id;
                                const name = toggle.dataset.name;
                                const status = toggle.checked ? "activate" : "deactivate";

                                Swal.fire({
                                    title: `${status === "activate" ? "Activate" : "Deactivate"} Permission?`,
                                    text: `Are you sure you want to ${status} "${name}"?`,
                                    icon: "warning",
                                    showCancelButton: true,
                                    confirmButtonColor: "#1e1e1e",
                                    cancelButtonColor: "#ffffff",
                                    confirmButtonText: "Yes",
                                    cancelButtonText: "Cancel",
                                }).then(result => {

                                    // CANCEL → rollback toggle
                                    if (!result.isConfirmed) {
                                        toggle.checked = !toggle.checked;
                                        return;
                                    }

                                    // REQUEST KE SERVER (TIDAK UPDATE UI DULU)
                                    fetch("{{ route('permissions.toggle-status') }}", {
                                            method: "POST",
                                            headers: {
                                                "X-CSRF-TOKEN": document
                                                    .querySelector(
                                                        'meta[name="csrf-token"]')
                                                    .content,
                                                "Content-Type": "application/json",
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
                                                    text: data.message ||
                                                        "Permission status updated successfully.",
                                                    icon: "success",
                                                    timer: 1200,
                                                    showConfirmButton: false
                                                }).then(() => location.reload());

                                            } else {
                                                Swal.fire("Error",
                                                        "Failed to update status.",
                                                        "error")
                                                    .then(() => location.reload());
                                            }

                                        })
                                        .catch(() => {
                                            Swal.fire(
                                                "Error",
                                                "Server error. Please try again later.",
                                                "error"
                                            ).then(() => location.reload());
                                        });

                                });
                            });
                        });

                        // =========================
                        // FILL EDIT MODAL
                        // =========================
                        const form = document.getElementById("editPermissionForm");

                        document.querySelectorAll(".btn-edit").forEach(btn => {
                            btn.addEventListener("click", () => {

                                const updateRoute =
                                    `{{ route('permissions.update', 'PERMISSION_ID') }}`
                                    .replace("PERMISSION_ID", btn.dataset.id);

                                form.action = updateRoute;

                                document.getElementById("edit-permission-id").value = btn
                                    .dataset.id ?? "";
                                document.getElementById("edit-permission-name").value = btn
                                    .dataset.name ?? "";
                                document.getElementById("edit-permission-guard").value = btn
                                    .dataset.guard ?? "";

                                // audit trail
                                document.getElementById("edit-permission-created").value =
                                    btn.dataset.created ?? "-";
                                document.getElementById("edit-permission-created-by").value =
                                    btn.dataset.createdBy ?? "System";
                                document.getElementById("edit-permission-updated-at").value =
                                    btn.dataset.updatedAt ?? "-";
                                document.getElementById("edit-permission-updated-by").value =
                                    btn.dataset.updatedBy ?? "-";
                            });
                        });

                        // =========================
                        // DELETE / ARCHIVE
                        // =========================
                        document.querySelectorAll(".btn-delete").forEach(btn => {
                            btn.addEventListener("click", () => {

                                const id = btn.dataset.id;
                                const name = btn.dataset.name;

                                Swal.fire({
                                    title: "Archive Permission?",
                                    text: `"${name}" will be archived and deactivated.`,
                                    icon: "warning",
                                    showCancelButton: true,
                                    confirmButtonColor: "#dc3545",
                                    cancelButtonColor: "#ffffff",
                                    confirmButtonText: "Yes, Archive",
                                    cancelButtonText: "Cancel",
                                }).then(result => {

                                    if (!result.isConfirmed) return;

                                    const url =
                                        "{{ route('permissions.destroy', 'ID') }}"
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
                                        })
                                        .then(res => res.json())
                                        .then(data => {
                                            Swal.fire({
                                                icon: "success",
                                                title: "Archived",
                                                text: data.message ||
                                                    "Permission archived successfully.",
                                                timer: 1200,
                                                showConfirmButton: false
                                            }).then(() => location.reload());
                                        })
                                        .catch(() => {
                                            Swal.fire(
                                                "Error",
                                                "Server error, please try again later.",
                                                "error"
                                            );
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
    </div>
</x-app-layout>