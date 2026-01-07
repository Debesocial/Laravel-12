{{-- CONTENT: SESSION MANAGER PAGE --}}
<x-app-layout>
    <div class="container-fluid mt-2" id="main-content">
        <div class="col-12">
            <div class="card adminuiux-card">
                <div class="card-body p-0">

                    {{-- Header --}}
                    <div class="p-4 pb-0">
                        <h5 class="mb-1 fw-bold">{{ __('Session Manager') }}</h5>
                        <small class="text-muted d-block">
                            {{ __('Monitor active user sessions, device, IP, and terminate suspicious activity.') }}
                        </small>
                    </div>

                    {{-- Table --}}
                    <div class="p-4">
                        <div class="table-responsive overflow-hidden">
                            <table id="datatables" class="table table-hover table-bordered w-100 nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-wrap">{{ __('Status') }}</th>
                                        <th class="text-wrap">{{ __('User') }}</th>
                                        <th class="text-wrap">{{ __('Session ID') }}</th>
                                        <th class="text-wrap">{{ __('IP Address') }}</th>
                                        <th class="text-wrap">{{ __('Device') }}</th>
                                        <th class="text-wrap">{{ __('Login Time') }}</th>
                                        <th class="text-wrap">{{ __('Last Activity') }}</th>
                                        <th class="text-end">{{ __('Actions') }}</th>
                                    </tr>

                                    {{-- Filter Row --}}
                                    <tr class="filter-row">
                                        <form method="GET" action="{{ route('session-manager') }}">
                                            <th><input name="user" class="form-control form-control-sm"
                                                    placeholder="User / Email" value="{{ request('user') }}"></th>
                                            <th><input name="session_id" class="form-control form-control-sm"
                                                    placeholder="Session ID" value="{{ request('session_id') }}"></th>
                                            <th><input name="ip_address" class="form-control form-control-sm"
                                                    placeholder="IP" value="{{ request('ip_address') }}"></th>
                                            <th><input name="agent" class="form-control form-control-sm"
                                                    placeholder="Device" value="{{ request('agent') }}"></th>
                                            <th><input type="date" name="login_date"
                                                    class="form-control form-control-sm"
                                                    value="{{ request('login_date') }}"></th>
                                            <th colspan="3"></th>
                                        </form>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($sessions as $session)
                                    <tr>
                                        {{-- STATUS --}}
                                        <td>
                                            @php $idle =
                                            now()->diffInMinutes(\Carbon\Carbon::createFromTimestamp($session->last_activity));
                                            @endphp
                                            @if($idle > 30)
                                            <span class="badge bg-secondary px-5">{{ __('Ended') }}</span>
                                            @else
                                            <span class="badge bg-success px-5">{{ __('Active') }}</span>
                                            @endif
                                        </td>

                                        {{-- USER --}}
                                        <td class="text-wrap" style="max-width: 180px; white-space: normal;">
                                            {{ $session->user_email ?? '-' }}
                                        </td>

                                        {{-- SESSION ID --}}
                                        <td class="text-break" style="max-width: 150px; white-space: normal;">
                                            {{ $session->id }}</td>

                                        {{-- IP --}}
                                        <td>{{ $session->ip_address ?? '-' }}</td>

                                        {{-- DEVICE --}}
                                        <td class="text-wrap" style="max-width: 220px; white-space: normal;">
                                            {{ $session->user_agent ?? '-' }}</td>

                                        {{-- LOGIN TIME --}}
                                        <td>{{ \Carbon\Carbon::createFromTimestamp($session->last_activity)->format('Y-m-d H:i:s') }}
                                        </td>

                                        {{-- LAST ACTIVITY --}}
                                        <td>{{ \Carbon\Carbon::createFromTimestamp($session->last_activity)->diffForHumans() }}
                                        </td>

                                        {{-- ACTIONS --}}
                                        <td class="text-end">

                                            {{-- DETAILS --}}
                                            <button class="btn btn-sm btn-link text-dark btn-detail-log"
                                                data-json="{{ json_encode((array)$session, JSON_PRETTY_PRINT) }}"
                                                data-bs-toggle="modal" data-bs-target="#detailLogModal">
                                                <i class="bi bi-eye"></i>
                                            </button>

                                            {{-- TERMINATE --}}
                                            <form action="{{ route('session-manager.terminate', $session->id) }}"
                                                method="POST" class="d-inline terminate-form">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-link text-danger">
                                                    <i class="bi bi-x-circle"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">
                                            {{ __('No active sessions found.') }}
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- MODAL JSON --}}
                    <div class="modal fade" id="detailLogModal" tabindex="-1">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content rounded-3">
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold">{{ __('Session Detail') }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <pre id="log-json-view" class="bg-light p-3 rounded small text-dark"
                                        style="white-space: pre-wrap; font-size: 12px;"></pre>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-dark rounded-pill"
                                        data-bs-dismiss="modal">&emsp;{{ __('Close') }}&emsp;</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                    document.addEventListener("DOMContentLoaded", () => {
                        // JSON DETAIL VIEWER
                        document.querySelectorAll(".btn-detail-log").forEach(btn => {
                            btn.addEventListener("click", () => {
                                document.getElementById("log-json-view").textContent = btn
                                    .dataset.json;
                            });
                        });
                        // SWEETALERT TERMINATE
                        document.querySelectorAll(".terminate-form").forEach(form => {
                            form.addEventListener("submit", function(e) {
                                e.preventDefault();
                                Swal.fire({
                                    title: "Terminate Session?",
                                    text: "This will log out the user immediately.",
                                    icon: "warning",
                                    showCancelButton: true,
                                    confirmButtonColor: "#dc3545",
                                    cancelButtonColor: "#6c757d",
                                    confirmButtonText: "Yes, terminate",
                                    cancelButtonText: "Cancel",
                                    reverseButtons: false
                                }).then((result) => {
                                    if (result.isConfirmed) form.submit();
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