<x-app-layout>
    <div class="container-fluid mt-2" id="main-content">
        <div class="row gx-3 gx-lg-4">
            <div class="col-12">
                <div class="card adminuiux-card">
                    <div class="card-body p-0">

                        {{-- Header Halaman Permission Management --}}
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

                        {{-- Tabel Permission --}}
                        <div class="p-4">
                            <div class="table-responsive overflow-hidden">
                                <table id="datatables" class="table table-hover table-bordered w-100 nowrap mb-0">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Permission Name') }}</th>
                                            <th>{{ __('Module / Guard') }}</th>
                                            <th>{{ __('Assigned To (Roles)') }}</th>
                                            <th data-hide="audit">{{ __('Created At') }}</th>
                                            <th data-hide="audit">{{ __('Created By') }}</th>
                                            <th data-hide="audit">{{ __('Last Updated At') }}</th>
                                            <th data-hide="audit">{{ __('Last Updated By') }}</th>
                                            <th class="text-end">{{ __('Action') }}</th>
                                        </tr>

                                        {{-- Filter Bar --}}
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
                                        {{-- Contoh Dummy Data --}}
                                        <tr>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input permission-toggle" type="checkbox"
                                                        checked data-name="View Data">
                                                </div>
                                            </td>
                                            <td>View Data</td>
                                            <td>web</td>
                                            <td>Manager, Supervisor</td>
                                            <td data-hide="audit">2024-12-12 10:30</td>
                                            <td data-hide="audit">system@example.com</td>
                                            <td data-hide="audit">2025-01-11 09:21</td>
                                            <td data-hide="audit">admin@example.com</td>
                                            <td class="text-end">
                                                <button class="btn btn-link btn-edit" data-id="99" data-name="View Data"
                                                    data-guard="web" data-created="2024-12-12 10:30"
                                                    data-created_by="system@example.com"
                                                    data-updated_at="2025-01-11 09:21"
                                                    data-updated_by="admin@example.com" data-bs-toggle="modal"
                                                    data-bs-target="#editPermissionModal">
                                                    <i class="bi bi-pencil"></i>
                                                </button>

                                                <button class="btn btn-link text-danger btn-delete"
                                                    data-name="View Data">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Modal Tambah Permission --}}
                        <div class="modal fade" id="addPermissionModal" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content rounded-3">
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{ __('Add Permission') }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form method="POST">@csrf
                                        <div class="modal-body">
                                            <label class="form-label fw-semibold">{{ __('Permission Name') }} <span
                                                    class="text-danger">*</span></label>
                                            <input name="name" class="form-control mb-3"
                                                placeholder="ex: view_report / edit_data" required>

                                            <label class="form-label fw-semibold">{{ __('Module / Guard') }} <span
                                                    class="text-danger">*</span></label>
                                            <input name="guard_name" class="form-control mb-3" placeholder="web / api"
                                                required>
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

                        {{-- Modal Edit Permission --}}
                        <div class="modal fade" id="editPermissionModal" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content rounded-3">
                                    <div class="modal-header">
                                        <h5 class="modal-title">{{ __('Edit Permission') }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <form id="editPermissionForm" method="POST">@csrf @method('PUT')
                                        <div class="modal-body">

                                            {{-- Hidden ID --}}
                                            <input type="hidden" id="edit-permission-id">

                                            <label class="form-label fw-semibold">
                                                {{ __('Permission Name') }} <span class="text-danger">*</span>
                                            </label>
                                            <input id="edit-permission-name" class="form-control mb-3"
                                                placeholder="Enter permission name" required>

                                            <label class="form-label fw-semibold">
                                                {{ __('Module / Guard') }} <span class="text-danger">*</span>
                                            </label>
                                            <input id="edit-permission-guard" class="form-control mb-3"
                                                placeholder="web / api" required>

                                            {{-- Audit Log --}}
                                            <div class="border rounded p-3 bg-light mt-4">
                                                <h6 class="text-secondary fw-bold mb-3">{{ __('Audit Information') }}
                                                </h6>

                                                <label class="form-label text-secondary">Created At</label>
                                                <input id="edit-permission-created" class="form-control mb-2" readonly>

                                                <label class="form-label text-secondary">Created By</label>
                                                <input id="edit-permission-created-by" class="form-control mb-2"
                                                    readonly>

                                                <label class="form-label text-secondary">Last Updated At</label>
                                                <input id="edit-permission-updated-at" class="form-control mb-2"
                                                    readonly>

                                                <label class="form-label text-secondary">Last Updated By</label>
                                                <input id="edit-permission-updated-by" class="form-control" readonly>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-dark rounded-pill"
                                                data-bs-dismiss="modal">&emsp;Close&emsp;</button>
                                            <button type="submit"
                                                class="btn btn-primary rounded-pill">&emsp;Update&emsp;</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- Script Handler (Status, Delete, Edit Fill Data) --}}
                        <script>
                        document.addEventListener("DOMContentLoaded", () => {

                            // Status toggle switch
                            document.querySelectorAll(".permission-toggle").forEach(tgl => {
                                tgl.addEventListener("change", () => {
                                    const name = tgl.dataset.name;
                                    const status = tgl.checked ? "activate" : "deactivate";

                                    Swal.fire({
                                        title: `${status === "activate" ? "Activate" : "Deactivate"} Permission?`,
                                        text: `Change status for "${name}"?`,
                                        icon: "warning",
                                        showCancelButton: true,
                                        confirmButtonColor: '#1e1e1e',
                                        cancelButtonColor: '#ffffff',
                                        confirmButtonText: "Yes",
                                        cancelButtonText: "Cancel",
                                    }).then((r) => {
                                        if (!r.isConfirmed) tgl.checked = !tgl.checked;
                                    });
                                });
                            });

                            // Delete confirmation
                            document.querySelectorAll(".btn-delete").forEach(btn => {
                                btn.addEventListener("click", () => {
                                    Swal.fire({
                                        title: "Delete Permission?",
                                        text: `Remove "${btn.dataset.name}" permanently?`,
                                        icon: "warning",
                                        showCancelButton: true,
                                        confirmButtonColor: "#d33",
                                        confirmButtonText: "Delete",
                                    });
                                });
                            });

                            // Fill form in edit modal
                            const form = document.getElementById("editPermissionForm");
                            document.querySelectorAll(".btn-edit").forEach(btn => {
                                btn.addEventListener("click", () => {

                                    form.action =
                                        `{{ url('admin/permissions') }}/${btn.dataset.id}`;

                                    document.getElementById("edit-permission-id").value = btn
                                        .dataset.id;
                                    document.getElementById("edit-permission-name").value = btn
                                        .dataset.name;
                                    document.getElementById("edit-permission-guard").value = btn
                                        .dataset.guard;
                                    document.getElementById("edit-permission-created").value =
                                        btn.dataset.created || "-";
                                    document.getElementById("edit-permission-created-by")
                                        .value = btn.dataset.created_by || "-";
                                    document.getElementById("edit-permission-updated-at")
                                        .value = btn.dataset.updated_at || "-";
                                    document.getElementById("edit-permission-updated-by")
                                        .value = btn.dataset.updated_by || "-";
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