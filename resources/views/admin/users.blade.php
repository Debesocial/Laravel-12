<x-app-layout>
    <div class="container-fluid mt-2" id="main-content">
        <div class="row gx-3 gx-lg-4">
            <div class="col-12">
                <div class="card adminuiux-card">
                    <div class="card-body p-0">

                        {{-- Header Halaman User Management --}}
                        <div class="p-4 pb-0">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h5 class="mb-0 fw-bold">{{ __('User Management') }}</h5>
                                    <small class="text-muted">
                                        {{ __('Manage users, assign roles, and control access levels within the application. Each user can have one or multiple roles based on their responsibilities.') }}
                                    </small>
                                </div>
                                <button class="btn btn-primary mt-3 px-3" data-bs-toggle="modal"
                                    data-bs-target="#addUserModal">
                                    &emsp;+ {{ __('Add User') }}&emsp;
                                </button>
                            </div>
                        </div>

                        {{-- Tabel User --}}
                        <div class="p-4">
                            <div class="table-responsive overflow-hidden">
                                <table id="datatables" class="table table-hover table-bordered w-100 nowrap mb-0">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('User Name') }}</th>
                                            <th>{{ __('Email') }}</th>
                                            <th>{{ __('Role') }}</th>
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
                                                    placeholder="{{ __('Search Name') }}"></th>
                                            <th><input class="form-control form-control-sm"
                                                    placeholder="{{ __('Search Email') }}"></th>
                                            <th><input class="form-control form-control-sm"
                                                    placeholder="{{ __('Search Role') }}"></th>
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
                                        {{-- Contoh Dummy User --}}
                                        <tr>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input user-toggle" type="checkbox" checked
                                                        data-name="John Doe">
                                                </div>
                                            </td>
                                            <td>John Doe</td>
                                            <td>john@example.com</td>
                                            <td>Manager</td>
                                            <td data-hide="audit">2024-10-22 09:35</td>
                                            <td data-hide="audit">admin@example.com</td>
                                            <td data-hide="audit">2025-01-12 15:22</td>
                                            <td data-hide="audit">admin@example.com</td>
                                            <td class="text-end">
                                                <button class="btn btn-link btn-edit" data-id="99" data-name="John Doe"
                                                    data-email="john@example.com" data-role="Manager"
                                                    data-status="active" data-created="2024-10-22 09:35"
                                                    data-created_by="admin@example.com"
                                                    data-updated_at="2025-01-12 15:22"
                                                    data-updated_by="admin@example.com" data-bs-toggle="modal"
                                                    data-bs-target="#editUserModal">
                                                    <i class="bi bi-pencil"></i>
                                                </button>

                                                <button class="btn btn-link text-danger btn-delete"
                                                    data-name="John Doe">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Modal Tambah User --}}
                        <div class="modal fade" id="addUserModal" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content rounded-3">

                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold">{{ __('Add User') }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <form method="POST">@csrf
                                        <div class="modal-body">

                                            <label class="form-label fw-semibold">
                                                {{ __('User Name') }} <span class="text-danger">*</span>
                                            </label>
                                            <input name="name" class="form-control mb-3" placeholder="ex: John Doe"
                                                required>

                                            <label class="form-label fw-semibold">
                                                {{ __('Email') }} <span class="text-danger">*</span>
                                            </label>
                                            <input name="email" type="email" class="form-control mb-3"
                                                placeholder="ex: john@example.com" required>

                                            <label class="form-label fw-semibold">
                                                {{ __('Role') }} <span class="text-danger">*</span>
                                            </label>
                                            <input name="role" class="form-control mb-3"
                                                placeholder="ex: Manager / Staff" required>

                                            <label class="form-label fw-semibold">{{ __('Status') }}</label>
                                            <select name="status" class="form-select">
                                                <option value="active" selected>Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>

                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-dark rounded-pill"
                                                data-bs-dismiss="modal">
                                                &emsp;{{ __('Close') }}&emsp;
                                            </button>
                                            <button type="submit" class="btn btn-dark rounded-pill">
                                                &emsp;{{ __('Save') }}&emsp;
                                            </button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                        {{-- Modal Edit User --}}
                        <div class="modal fade" id="editUserModal" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content rounded-3">

                                    <div class="modal-header">
                                        <h5 class="modal-title">{{ __('Edit User') }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <form id="editUserForm" method="POST">@csrf @method('PUT')
                                        <div class="modal-body">

                                            {{-- Hidden ID --}}
                                            <input type="hidden" id="edit-user-id">

                                            <label class="form-label fw-semibold">
                                                {{ __('User Name') }} <span class="text-danger">*</span>
                                            </label>
                                            <input id="edit-user-name" class="form-control mb-3"
                                                placeholder="Enter full name" required>

                                            <label class="form-label fw-semibold">
                                                {{ __('Email') }} <span class="text-danger">*</span>
                                            </label>
                                            <input id="edit-user-email" type="email" class="form-control mb-3"
                                                placeholder="Enter email" required>

                                            <label class="form-label fw-semibold">
                                                {{ __('Role') }} <span class="text-danger">*</span>
                                            </label>
                                            <input id="edit-user-role" class="form-control mb-3"
                                                placeholder="Enter role" required>

                                            <label class="form-label fw-semibold">{{ __('Status') }}</label>
                                            <select id="edit-user-status" class="form-select mb-3">
                                                <option value="active">{{ __('Active') }}</option>
                                                <option value="inactive">{{ __('Inactive') }}</option>
                                            </select>

                                            {{-- Audit Log --}}
                                            <div class="border rounded p-3 bg-light">
                                                <h6 class="fw-bold text-secondary mb-3">{{ __('Audit Information') }}
                                                </h6>

                                                <label class="form-label text-secondary">Created At</label>
                                                <input id="edit-user-created" class="form-control mb-2" readonly>

                                                <label class="form-label text-secondary">Created By</label>
                                                <input id="edit-user-created-by" class="form-control mb-2" readonly>

                                                <label class="form-label text-secondary">Last Updated At</label>
                                                <input id="edit-user-updated-at" class="form-control mb-2" readonly>

                                                <label class="form-label text-secondary">Last Updated By</label>
                                                <input id="edit-user-updated-by" class="form-control" readonly>
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

                        {{-- Script Handler (Toggle, Delete, Fill Data Edit) --}}
                        <script>
                        document.addEventListener("DOMContentLoaded", () => {

                            // Toggle status aktif/inaktif
                            document.querySelectorAll(".user-toggle").forEach(tgl => {
                                tgl.addEventListener("change", () => {
                                    const name = tgl.dataset.name;
                                    const action = tgl.checked ? "Activate" : "Deactivate";

                                    Swal.fire({
                                        title: `${action} User?`,
                                        text: `Do you want to ${action.toLowerCase()} "${name}"?`,
                                        icon: "warning",
                                        showCancelButton: true,
                                        confirmButtonColor: '#1e1e1e',
                                        cancelButtonColor: '#ffffff',
                                        confirmButtonText: "Yes",
                                        cancelButtonText: "Cancel",
                                    }).then(r => {
                                        if (!r.isConfirmed) tgl.checked = !tgl.checked;
                                    });
                                });
                            });

                            // Konfirmasi delete user
                            document.querySelectorAll(".btn-delete").forEach(btn => {
                                btn.addEventListener("click", () => {
                                    Swal.fire({
                                        title: "Delete User?",
                                        text: `Remove "${btn.dataset.name}" permanently?`,
                                        icon: "warning",
                                        showCancelButton: true,
                                        confirmButtonColor: "#d33",
                                        confirmButtonText: "Delete",
                                    });
                                });
                            });

                            // Isi modal edit dengan data user
                            document.querySelectorAll(".btn-edit").forEach(btn => {
                                btn.addEventListener("click", () => {

                                    const form = document.getElementById("editUserForm");
                                    form.action = `{{ url('admin/users') }}/${btn.dataset.id}`;

                                    document.getElementById("edit-user-id").value = btn.dataset
                                        .id;
                                    document.getElementById("edit-user-name").value = btn
                                        .dataset.name;
                                    document.getElementById("edit-user-email").value = btn
                                        .dataset.email;
                                    document.getElementById("edit-user-role").value = btn
                                        .dataset.role;
                                    document.getElementById("edit-user-status").value = btn
                                        .dataset.status;

                                    document.getElementById("edit-user-created").value = btn
                                        .dataset.created || "-";
                                    document.getElementById("edit-user-created-by").value = btn
                                        .dataset.created_by || "-";
                                    document.getElementById("edit-user-updated-at").value = btn
                                        .dataset.updated_at || "-";
                                    document.getElementById("edit-user-updated-by").value = btn
                                        .dataset.updated_by || "-";
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