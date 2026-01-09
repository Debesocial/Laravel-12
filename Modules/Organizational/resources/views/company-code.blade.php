<x-app-layout>
    <div class="container-fluid mt-2" id="main-content">
        <div class="row gx-3 gx-lg-4"></div>
        <div class="col-12">
            <div class="card adminuiux-card">
                <div class="card-body p-0">

                    {{-- HEADER --}}
                    <div class="p-4 pb-0">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h5 class="mb-0 fw-bold">{{ __('Company Code Management') }}</h5>
                                <small class="text-muted">
                                    {{ __('Manage company codes used in organizational structure.') }}
                                </small>
                            </div>

                            @can('manage company codes')
                            <button class="btn btn-primary mt-3 px-3"
                                data-bs-toggle="modal"
                                data-bs-target="#addCompanyCodeModal">
                                &emsp;+ {{ __('Add Company Code') }}&emsp;
                            </button>
                            @endcan
                        </div>
                    </div>

                    {{-- TABLE --}}
                    <div class="p-4">
                        <div class="table-responsive overflow-hidden">
                            <table id="datatables" class="table table-hover table-bordered w-100 mb-0">
                                <thead>
                                    <tr>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Code') }}</th>
                                        <th>{{ __('Company Name') }}</th>
                                        <th data-hide="audit">{{ __('Created At') }}</th>
                                        <th data-hide="audit">{{ __('Created By') }}</th>
                                        <th data-hide="audit">{{ __('Last Updated At') }}</th>
                                        <th data-hide="audit">{{ __('Last Updated By') }}</th>
                                        <th class="text-end" width="10%">{{ __('Action') }}</th>
                                    </tr>

                                    {{-- FILTER --}}
                                    <tr class="filter-row">
                                        <th>
                                            <select class="form-select form-select-sm">
                                                <option value="">{{ __('All') }}</option>
                                                <option value="active">{{ __('Active') }}</option>
                                                <option value="inactive">{{ __('Inactive') }}</option>
                                            </select>
                                        </th>
                                        <th>
                                            <input class="form-control form-control-sm"
                                                placeholder="{{ __('Search Code') }}">
                                        </th>
                                        <th>
                                            <input class="form-control form-control-sm"
                                                placeholder="{{ __('Search Company Name') }}">
                                        </th>
                                        <th><input type="date" class="form-control form-control-sm"></th>
                                        <th>
                                            <input class="form-control form-control-sm"
                                                placeholder="{{ __('Search User') }}">
                                        </th>
                                        <th><input type="date" class="form-control form-control-sm"></th>
                                        <th>
                                            <input class="form-control form-control-sm"
                                                placeholder="{{ __('Search User') }}">
                                        </th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($companyCodes as $companyCode)
                                    <tr>
                                        {{-- STATUS --}}
                                        <td>
                                            <div class="form-check form-switch d-flex align-items-center gap-2">
                                                <input class="form-check-input company-toggle" type="checkbox"
                                                    {{ $companyCode->is_active ? 'checked' : '' }}
                                                    data-id="{{ $companyCode->id }}"
                                                    data-name="{{ $companyCode->name }}">
                                                <span class="status-label {{ $companyCode->is_active ? 'text-success' : 'text-danger' }}">
                                                    {{ $companyCode->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </div>
                                        </td>

                                        <td>{{ $companyCode->code }}</td>
                                        <td>{{ $companyCode->name }}</td>
                                        <td>{{ $companyCode->created_at }}</td>
                                        <td>{{ $companyCode->creator->email ?? 'System' }}</td>
                                        <td>{{ $companyCode->updated_at }}</td>
                                        <td>{{ $companyCode->updater->email ?? '-' }}</td>

                                        <td class="text-end">
                                            @can('manage company codes')
                                            <button class="btn btn-link btn-edit"
                                                data-id="{{ $companyCode->id }}"
                                                data-name="{{ $companyCode->name }}"
                                                data-created="{{ $companyCode->created_at }}"
                                                data-created-by="{{ $companyCode->creator->email ?? 'System' }}"
                                                data-updated-at="{{ $companyCode->updated_at }}"
                                                data-updated-by="{{ $companyCode->updater->email ?? '-' }}"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editCompanyCodeModal">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <button class="btn btn-link text-danger btn-delete"
                                                data-id="{{ $companyCode->id }}"
                                                data-name="{{ $companyCode->name }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                            @endcan
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">
                                            {{ __('No company code found') }}
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- ADD MODAL --}}
                    <div class="modal fade" id="addCompanyCodeModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-3">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{ __('Add Company Code') }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <form method="POST"
                                    action="{{ route('organizational.company-codes.store') }}"
                                    autocomplete="off">
                                    @csrf

                                    {{-- anti autofill --}}
                                    <input type="text" name="fakeuser" style="display:none">
                                    <input type="password" name="fakepass" style="display:none">

                                    <div class="modal-body">
                                        <label class="form-label fw-semibold">
                                            {{ __('Company Name') }} <span class="text-danger">*</span>
                                        </label>
                                        <input type="text"
                                            name="name"
                                            class="form-control"
                                            placeholder="{{ __('ex: PT. Inovasi Tanpa Batas') }}"
                                            required
                                            minlength="3"
                                            maxlength="100"
                                            title="Minimum 3 characters">
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

                    {{-- EDIT MODAL --}}
                    <div class="modal fade" id="editCompanyCodeModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-3">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{ __('Edit Company Code') }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <form id="editCompanyCodeForm" method="POST" autocomplete="off">
                                    @csrf
                                    @method('PUT')

                                    {{-- anti autofill --}}
                                    <input type="text" name="fakeuser" style="display:none">
                                    <input type="password" name="fakepass" style="display:none">

                                    <div class="modal-body">
                                        <label class="form-label fw-semibold">
                                            {{ __('Company Name') }} <span class="text-danger">*</span>
                                        </label>
                                        <input id="edit-name" name="name"
                                            class="form-control mb-3"
                                            placeholder="{{ __('ex: PT. Inovasi Tanpa Batas') }}"
                                            required>

                                        {{-- AUDIT --}}
                                        <div class="border rounded p-3 bg-light">
                                            <h6 class="text-secondary fw-bold mb-3">{{ __('Audit Information') }}</h6>

                                            <label class="form-label text-secondary">{{ __('Created At') }}</label>
                                            <input id="edit-created" class="form-control mb-2" readonly>

                                            <label class="form-label text-secondary">{{ __('Created By') }}</label>
                                            <input id="edit-created-by" class="form-control mb-2" readonly>

                                            <label class="form-label text-secondary">{{ __('Last Updated At') }}</label>
                                            <input id="edit-updated-at" class="form-control mb-2" readonly>

                                            <label class="form-label text-secondary">{{ __('Last Updated By') }}</label>
                                            <input id="edit-updated-by" class="form-control" readonly>
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

                    // ================================
                    // TOGGLE STATUS (Company Code)
                    // ================================
                    document.querySelectorAll(".company-toggle").forEach(toggle => {
                        toggle.addEventListener("change", () => {

                            const id = toggle.dataset.id;
                            const name = toggle.dataset.name;
                            const status = toggle.checked ? "activate" : "deactivate";
                            const label = toggle.closest(".form-switch").querySelector(".status-label");

                            Swal.fire({
                                title: `${status === "activate" ? "Activate" : "Deactivate"} Company Code?`,
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
                                fetch("{{ route('organizational.company-codes.toggle-status') }}", {
                                    method: "POST",
                                    headers: {
                                        "Content-Type": "application/json",
                                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                    },
                                    body: JSON.stringify({ id, status }),
                                })
                                .then(res => res.json())
                                .then(data => {

                                    if (!data.success) {
                                        throw new Error("Failed");
                                    }

                                    Swal.fire({
                                        title: "Success",
                                        text: "Company Code status updated successfully.",
                                        icon: "success",
                                        timer: 1200,
                                        showConfirmButton: false
                                    }).then(() => location.reload());

                                })
                                .catch(() => {
                                    Swal.fire("Error", "Failed to update status.", "error");
                                    toggle.checked = !toggle.checked;
                                    label.textContent = toggle.checked ? "Active" : "Inactive";
                                    label.classList.toggle("text-success", toggle.checked);
                                    label.classList.toggle("text-danger", !toggle.checked);
                                });
                            });
                        });
                    });

                    // ================================
                    // FILL FORM EDIT
                    // ================================
                    document.querySelectorAll(".btn-edit").forEach(btn => {
                        btn.addEventListener("click", () => {

                            const url =
                                "{{ route('organizational.company-codes.update', 'ID') }}"
                                    .replace("ID", btn.dataset.id);

                            document.getElementById("editCompanyCodeForm").action = url;

                            document.getElementById("edit-name").value = btn.dataset.name;
                            document.getElementById("edit-created").value = btn.dataset.created;
                            document.getElementById("edit-created-by").value = btn.dataset.createdBy;
                            document.getElementById("edit-updated-at").value = btn.dataset.updatedAt;
                            document.getElementById("edit-updated-by").value = btn.dataset.updatedBy;
                        });
                    });

                    // ================================
                    // DELETE / ARCHIVE
                    // ================================
                    document.querySelectorAll(".btn-delete").forEach(btn => {
                        btn.addEventListener("click", () => {

                            const id = btn.dataset.id;
                            const name = btn.dataset.name;

                            Swal.fire({
                                title: "Archive Company Code?",
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
                                    "{{ route('organizational.company-codes.destroy', 'ID') }}"
                                        .replace("ID", id);

                                fetch(url, {
                                    method: "DELETE",
                                    headers: {
                                        "X-CSRF-TOKEN": document
                                            .querySelector('meta[name="csrf-token"]').content,
                                        "Accept": "application/json",
                                    }
                                })
                                .then(res => res.json())
                                .then(data => {

                                    Swal.fire({
                                        icon: "success",
                                        title: "Archived",
                                        text: data.message || "Company Code archived successfully.",
                                        timer: 1200,
                                        showConfirmButton: false
                                    }).then(() => location.reload());

                                })
                                .catch(() => {
                                    Swal.fire("Error", "Server error, please try again.", "error");
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
