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
                                <h5 class="mb-0 fw-bold">{{ __('Notification Center') }}</h5>
                                <small class="text-muted">
                                    {{ __('Manage system notifications, alerts, and user messages in one place.') }}
                                </small>
                            </div>
                            <button class="btn btn-primary mt-3 px-3" data-bs-toggle="modal"
                                data-bs-target="#sendNotificationModal">
                                &emsp;+ {{ __('Send Notification') }}&emsp;
                            </button>
                        </div>
                    </div>

                    {{-- TABLE --}}
                    <div class="p-4">
                        <div class="table-responsive overflow-hidden">
                            <table id="datatables" class="table table-hover table-bordered w-100 nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-wrap">{{ __('Status') }}</th>
                                        <th class="text-wrap">{{ __('Title') }}</th>
                                        <th class="text-wrap">{{ __('Message') }}</th>
                                        <th class="text-wrap">{{ __('Recipient') }}</th>
                                        <th class="text-wrap">{{ __('Type') }}</th>
                                        <th class="text-wrap" data-hide="audit">{{ __('Created At') }}</th>
                                        <th class="text-end text-wrap">{{ __('Action') }}</th>
                                    </tr>

                                    {{-- FILTER BAR --}}
                                    <tr class="filter-row">
                                        <th>
                                            <select class="form-select form-select-sm">
                                                <option value="">{{ __('All') }}</option>
                                                <option value="read">{{ __('Read') }}</option>
                                                <option value="unread">{{ __('Unread') }}</option>
                                            </select>
                                        </th>
                                        <th>
                                            <input class="form-control form-control-sm"
                                                placeholder="{{ __('Search title') }}">
                                        </th>
                                        <th>
                                            <input class="form-control form-control-sm"
                                                placeholder="{{ __('Search message') }}">
                                        </th>
                                        <th>
                                            <select class="form-select form-select-sm">
                                                <option value="">{{ __('All') }}</option>
                                                <option value="all">All</option>
                                                <option value="admin">Admin</option>
                                                <option value="user">User</option>
                                            </select>
                                        </th>
                                        <th>
                                            <select class="form-select form-select-sm">
                                                <option value="">{{ __('All') }}</option>
                                                <option value="info">Info</option>
                                                <option value="warning">Warning</option>
                                                <option value="system">System</option>
                                            </select>
                                        </th>
                                        <th>
                                            <input type="date" class="form-control form-control-sm">
                                        </th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($notifications as $notification)
                                    <tr>
                                        <td>
                                            @if ($notification->read_at)
                                            <span class="badge bg-success px-5">
                                                {{ __('Read') }}
                                            </span>
                                            @else
                                            <span class="badge bg-warning text-dark px-5">
                                                {{ __('Unread') }}
                                            </span>
                                            @endif
                                        </td>

                                        <td>{{ $notification->title }}</td>
                                        <td class="text-wrap">{{ $notification->message }}</td>
                                        <td>{{ ucfirst($notification->recipient) }}</td>
                                        <td>{{ ucfirst($notification->type) }}</td>
                                        <td data-hide="audit">{{ $notification->created_at }}</td>
                                        <td class="text-end">

                                            @if (!$notification->read_at)
                                            <button class="btn btn-link btn-mark-read"
                                                data-url="{{ route('notification-center.read', $notification) }}">
                                                <i class="bi bi-check2-circle"></i>
                                            </button>
                                            @endif

                                            <button class="btn btn-link text-danger btn-delete"
                                                data-url="{{ route('notification-center.destroy', $notification) }}">
                                                <i class="bi bi-trash"></i>
                                            </button>

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>

                    {{-- MODAL SEND NOTIFICATION --}}
                    <div class="modal fade" id="sendNotificationModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-3">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{ __('Send Notification') }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <form method="POST" action="{{ route('notification-center.store') }}">
                                    @csrf
                                    <div class="modal-body">

                                        <label class="form-label fw-semibold">
                                            {{ __('Title') }} <span class="text-danger">*</span>
                                        </label>
                                        <input name="title" class="form-control mb-3"
                                            placeholder="{{ __('Enter notification title') }}" required>

                                        <label class="form-label fw-semibold">
                                            {{ __('Message') }} <span class="text-danger">*</span>
                                        </label>
                                        <textarea name="message" rows="4" class="form-control mb-3"
                                            placeholder="{{ __('Write notification message') }}" required></textarea>

                                        <label class="form-label fw-semibold">
                                            {{ __('Recipient') }} <span class="text-danger">*</span>
                                        </label>
                                        <select name="recipient" class="form-select mb-3" required>
                                            <option value="all">All Users</option>
                                            <option value="admin">Admins</option>
                                            <option value="user">Users</option>
                                        </select>

                                        <label class="form-label fw-semibold">{{ __('Type') }}</label>
                                        <select name="type" class="form-select">
                                            <option value="info">Information</option>
                                            <option value="warning">Warning</option>
                                            <option value="system">System</option>
                                        </select>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-dark rounded-pill"
                                            data-bs-dismiss="modal">
                                            &emsp;Close&emsp;
                                        </button>
                                        <button type="submit" class="btn btn-dark rounded-pill">
                                            &emsp;Send&emsp;
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- SCRIPT HANDLER --}}
                    <script>
                    document.addEventListener("DOMContentLoaded", () => {

                        // MARK AS READ
                        document.querySelectorAll(".btn-mark-read").forEach(btn => {
                            btn.addEventListener("click", () => {
                                const url = btn.dataset.url;
                                Swal.fire({
                                    title: "{{ __('Mark notification as read?') }}",
                                    icon: "question",
                                    showCancelButton: true,
                                    confirmButtonColor: "#1e1e1e",
                                    confirmButtonText: "{{ __('Yes') }}",
                                    cancelButtonText: "{{ __('Cancel') }}"
                                }).then(result => {
                                    if (!result.isConfirmed) return;

                                    fetch(url, {
                                        method: "PATCH",
                                        headers: {
                                            "X-CSRF-TOKEN": document
                                                .querySelector(
                                                    'meta[name="csrf-token"]')
                                                .content,
                                            "Accept": "application/json"
                                        }
                                    }).then(() => location.reload());
                                });
                            });
                        });

                        // DELETE
                        document.querySelectorAll(".btn-delete").forEach(btn => {
                            btn.addEventListener("click", () => {
                                const url = btn.dataset.url;

                                Swal.fire({
                                    title: "{{ __('Delete this notification?') }}",
                                    text: "{{ __('This action cannot be undone.') }}",
                                    icon: "warning",
                                    showCancelButton: true,
                                    confirmButtonColor: "#dc3545",
                                    confirmButtonText: "{{ __('Delete') }}",
                                    cancelButtonText: "{{ __('Cancel') }}"
                                }).then(result => {
                                    if (!result.isConfirmed) return;

                                    fetch(url, {
                                        method: "DELETE",
                                        headers: {
                                            "X-CSRF-TOKEN": document
                                                .querySelector(
                                                    'meta[name="csrf-token"]')
                                                .content,
                                            "Accept": "application/json"
                                        }
                                    }).then(() => location.reload());
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