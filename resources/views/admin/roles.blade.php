<x-app-layout>
    <div class="container-fluid mt-2" id="main-content">
        <div class="row gx-3 gx-lg-4">
            <div class="col-12">
                <div class="card adminuiux-card">
                    <div class="card-body p-0">

                        {{-- Header Halaman Role Management --}}
                        <div class="p-4 pb-0">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h5 class="mb-0 fw-bold">{{ __('Role Management') }}</h5>
                                    <small class="text-muted">
                                        {{ __('Manage roles and permissions to control access to application features. Each role can have multiple permissions.') }}
                                    </small>
                                </div>
                                <button class="btn btn-primary mt-3 px-3" data-bs-toggle="modal"
                                    data-bs-target="#addRoleModal">
                                    &emsp;+ {{ __('Add Role') }}&emsp;
                                </button>
                            </div>
                        </div>

                        {{-- Tabel Role --}}
                        <div class="p-4">
                            <div class="table-responsive overflow-hidden">
                                <table id="datatables" class="table table-hover table-bordered w-100 nowrap mb-0">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Role Name') }}</th>
                                            <th>{{ __('Guard') }}</th>
                                            <th>{{ __('Permissions') }}</th>
                                            <th data-hide="audit">{{ __('Created At') }}</th>
                                            <th data-hide="audit">{{ __('Created By') }}</th>
                                            <th data-hide="audit">{{ __('Last Updated At') }}</th>
                                            <th data-hide="audit">{{ __('Last Updated By') }}</th>
                                            <th class="text-end">{{ __('Action') }}</th>
                                        </tr>

                                        {{-- Filter Header --}}
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
                                        {{-- Contoh Dummy Data --}}
                                        <tr>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input role-toggle" type="checkbox" checked
                                                        data-name="Manager">
                                                </div>
                                            </td>
                                            <td>Manager</td>
                                            <td>web</td>
                                            <td>edit, view, report</td>
                                            <td>2024-12-12 10:30</td>
                                            <td>system@example.com</td>
                                            <td>2025-01-05 14:21</td>
                                            <td>admin@example.com</td>
                                            <td class="text-end">
                                                <button class="btn btn-link btn-edit" data-id="99" data-name="Manager"
                                                    data-guard="web" data-permissions='[1,2,3]'
                                                    data-created="2024-12-12 10:30" data-created_by="system@example.com"
                                                    data-updated_at="2025-01-05 14:21"
                                                    data-updated_by="admin@example.com" data-bs-toggle="modal"
                                                    data-bs-target="#editRoleModal">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-link text-danger btn-delete" data-name="Manager">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Modal Tambah Role --}}
                        <div class="modal fade" id="addRoleModal" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content rounded-3">
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{ __('Add Role') }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form method="POST">@csrf
                                        <div class="modal-body">
                                            {{-- Field Role Name --}}
                                            <label class="form-label fw-semibold">Role Name <span
                                                    class="text-danger">*</span></label>
                                            <input name="name" class="form-control mb-3"
                                                placeholder="Enter role name (ex: Administrator)" required>

                                            {{-- Field Guard Name --}}
                                            <label class="form-label fw-semibold">Guard <span
                                                    class="text-danger">*</span></label>
                                            <input name="guard_name" class="form-control mb-3" placeholder="web / api"
                                                required>

                                            {{-- Select Permissions --}}
                                            <label class="form-label fw-semibold">Permissions <span
                                                    class="text-danger">*</span></label>
                                            <select id="permissionsSelect" name="permissions[]" multiple required>
                                                <option value="1">Edit</option>
                                                <option value="2">View</option>
                                                <option value="3">Report</option>
                                                <option value="4">Export</option>
                                                <option value="5">Archive</option>
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-dark rounded-pill"
                                                data-bs-dismiss="modal">&emsp;Close&emsp;</button>
                                            <button type="submit"
                                                class="btn btn-dark rounded-pill">&emsp;Save&emsp;</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- Modal Edit Role --}}
                        <div class="modal fade" id="editRoleModal" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content rounded-3">

                                    <div class="modal-header">
                                        <h5 class="modal-title">{{ __('Edit Role') }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <form id="editRoleForm" method="POST">@csrf @method('PUT')
                                        <div class="modal-body">

                                            {{-- ID Role (Hidden) --}}
                                            <input type="hidden" id="edit-role-id">

                                            <label class="form-label fw-semibold">Role Name *</label>
                                            <input id="edit-role-name" name="name" class="form-control mb-3" required>

                                            <label class="form-label fw-semibold">Guard *</label>
                                            <input id="edit-role-guard" name="guard_name" class="form-control mb-3"
                                                required>

                                            {{-- Permissions --}}
                                            <label class="form-label fw-semibold">{{ __('Permissions') }} *</label>
                                            <select id="permissionsSelect2" name="permissions[]" multiple required>
                                                <option value="1">Edit</option>
                                                <option value="2">View</option>
                                                <option value="3">Report</option>
                                                <option value="4">Export</option>
                                                <option value="5">Archive</option>
                                            </select>

                                            {{-- Informasi Audit --}}
                                            <div class="border rounded p-3 mt-4 bg-light">
                                                <h6 class="fw-bold text-secondary mb-3">{{ __('Audit Information') }}
                                                </h6>

                                                <label class="form-label text-secondary">Created At</label>
                                                <input id="edit-role-created" class="form-control mb-3" readonly>

                                                <label class="form-label text-secondary">Created By</label>
                                                <input id="edit-role-created-by" class="form-control mb-3" readonly>

                                                <label class="form-label text-secondary">Last Updated At</label>
                                                <input id="edit-role-updated-at" class="form-control mb-3" readonly>

                                                <label class="form-label text-secondary">Last Updated By</label>
                                                <input id="edit-role-updated-by" class="form-control" readonly>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-dark rounded-pill"
                                                data-bs-dismiss="modal">
                                                &emsp;Close&emsp;
                                            </button>
                                            <button type="submit"
                                                class="btn btn-primary rounded-pill">&emsp;Update&emsp;</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                        {{-- Script Handling Role Actions --}}
                        <script>
                        document.addEventListener('DOMContentLoaded', () => {

                            // Inisialisasi Choices untuk input permissions
                            new Choices('#permissionsSelect', {
                                removeItemButton: true,
                                searchEnabled: true,
                                placeholder: true,
                                placeholderValue: 'Select permissions'
                            });
                            const editChoices = new Choices('#permissionsSelect2', {
                                removeItemButton: true,
                                searchEnabled: true,
                                placeholder: true,
                                placeholderValue: 'Select permissions'
                            });

                            // Toggle status role (aktif/nonaktif)
                            document.querySelectorAll(".role-toggle").forEach(toggle => {
                                toggle.addEventListener("change", () => {
                                    const name = toggle.dataset.name;
                                    const action = toggle.checked ? "activate" : "deactivate";

                                    Swal.fire({
                                        title: `${action === "activate" ? "Activate" : "Deactivate"} Role?`,
                                        text: `Are you sure to ${action} "${name}"?`,
                                        icon: "warning",
                                        showCancelButton: true,
                                        confirmButtonColor: '#1e1e1e',
                                        cancelButtonColor: '#ffffff',
                                        confirmButtonText: "Yes",
                                        cancelButtonText: "Cancel",
                                    }).then(result => {
                                        if (!result.isConfirmed) {
                                            toggle.checked = !toggle.checked;
                                        }
                                    });
                                });
                            });

                            // Konfirmasi delete role
                            document.querySelectorAll('.btn-delete').forEach(btn => {
                                btn.addEventListener('click', () => {
                                    Swal.fire({
                                        title: "Delete Role?",
                                        text: `Remove "${btn.dataset.name}" permanently?`,
                                        icon: "warning",
                                        showCancelButton: true,
                                        confirmButtonText: "Delete",
                                        cancelButtonText: "Cancel"
                                    });
                                });
                            });

                            // Isi form edit dengan data role
                            document.querySelectorAll('.btn-edit').forEach(btn => {
                                btn.addEventListener('click', () => {

                                    document.getElementById('edit-role-id').value = btn.dataset
                                        .id;
                                    document.getElementById('edit-role-name').value = btn
                                        .dataset.name;
                                    document.getElementById('edit-role-guard').value = btn
                                        .dataset.guard;
                                    document.getElementById('edit-role-created').value = btn
                                        .dataset.created;
                                    document.getElementById('edit-role-created-by').value = btn
                                        .dataset.created_by;
                                    document.getElementById('edit-role-updated-at').value = btn
                                        .dataset.updated_at || "-";
                                    document.getElementById('edit-role-updated-by').value = btn
                                        .dataset.updated_by || "-";

                                    try {
                                        const perms = JSON.parse(btn.dataset.permissions);
                                        editChoices.removeActiveItems();
                                        editChoices.setChoiceByValue(perms.map(String));
                                    } catch {
                                        editChoices.removeActiveItems();
                                    }
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