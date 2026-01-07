<x-app-layout>
    <div class="container-fluid mt-2" id="main-content">
        <div class="row gx-3 gx-lg-4"></div>
        <div class="col-12">
            <div class="card adminuiux-card">
                <div class="card-body p-0">

                    {{-- header halaman action log --}}
                    <div class="p-4 pb-0">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h5 class="mb-0 fw-bold">{{ __('Action Log') }}</h5>
                                <small class="text-muted">
                                    {{ __('Monitor all recorded user actions within the system, including authentication, CRUD activities, and administrative events.') }}
                                </small>
                            </div>
                        </div>
                    </div>

                    {{-- tabel action log --}}
                    <div class="p-4">
                        <div class="table-responsive overflow-hidden">
                            <table id="datatables" class="table table-hover table-bordered w-100 nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-wrap">{{ __('User') }}</th>
                                        <th class="text-wrap">{{ __('Action') }}</th>
                                        <th class="text-wrap">{{ __('Description / Information') }}</th>
                                        <th class="text-wrap">{{ __('Module') }}</th>
                                        <th class="text-wrap">{{ __('Executed At') }}</th>
                                        <th class="text-wrap" data-hide="audit">{{ __('IP Address') }}</th>
                                        <th class="text-wrap" data-hide="audit">{{ __('Device / Agent') }}</th>
                                        <th class="text-wrap" data-hide="audit">{{ __('Properties') }}</th>
                                        <th class="text-end text-wrap">{{ __('Details') }}</th>
                                    </tr>

                                    {{-- filter bar --}}
                                    <tr class="filter-row">
                                        <form method="GET" action="{{ route('action-logs') }}">
                                            <th><input name="user" class="form-control form-control-sm"
                                                    placeholder="{{ __('Search User') }}" value="{{ request('user') }}">
                                            </th>

                                            <th><input name="action" class="form-control form-control-sm"
                                                    placeholder="{{ __('Search Action') }}"
                                                    value="{{ request('action') }}"></th>

                                            <th><input name="keyword" class="form-control form-control-sm"
                                                    placeholder="{{ __('Keyword') }}" value="{{ request('keyword') }}">
                                            </th>

                                            <th><input name="module" class="form-control form-control-sm"
                                                    placeholder="{{ __('Module') }}" value="{{ request('module') }}">
                                            </th>

                                            <th><input type="date" name="date" class="form-control form-control-sm"
                                                    value="{{ request('date') }}"></th>

                                            <th><input name="ip_address" class="form-control form-control-sm"
                                                    placeholder="{{ __('IP Address') }}"
                                                    value="{{ request('ip_address') }}"></th>

                                            <th><input name="agent" class="form-control form-control-sm"
                                                    placeholder="{{ __('Agent Keyword') }}"
                                                    value="{{ request('agent') }}"></th>

                                            <th><input name="properties" class="form-control form-control-sm"
                                                    placeholder="{{ __('Properties Keyword') }}"
                                                    value="{{ request('properties') }}"></th>


                                            <th>
                                            </th>
                                        </form>
                                    </tr>

                                </thead>

                                <tbody>
                                    @forelse ($actionlogs as $log)
                                    <tr>
                                        <td>{{ $log->causer?->email ?? 'System' }}</td>
                                        <td>{{ $log->description }}</td>
                                        <td>{{ $log->properties['details'] ?? '-' }}</td>
                                        <td>{{ $log->log_name ?? '-' }}</td>
                                        <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                                        <td>{{ $log->properties['ip'] ?? '-' }}</td>
                                        <td>{{ $log->properties['agent'] ?? '-' }}</td>
                                        <td>{{ $log->properties ?? '-' }}</td>
                                        <td class="text-end">
                                            {{-- tombol lihat detail log --}}
                                            <button class="btn btn-link btn-sm text-dark btn-detail-log"
                                                data-json="{{ json_encode($log->toArray(), JSON_PRETTY_PRINT) }}"
                                                data-bs-toggle="modal" data-bs-target="#detailLogModal">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">
                                            {{ __('Belum ada action log.') }}
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- modal detail log --}}
                    <div class="modal fade" id="detailLogModal" tabindex="-1">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content rounded-3">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{ __('Action Log Detail') }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">

                                    {{-- Blade comment: JSON detail viewer untuk audit --}}
                                    <pre id="log-json-view" class="bg-light p-3 rounded small text-dark"
                                        style="white-space: pre-wrap; font-size: 12px;"></pre>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-dark rounded-pill"
                                        data-bs-dismiss="modal">&emsp;Close&emsp;</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Script detail JSON --}}
                    <script>
                    document.addEventListener("DOMContentLoaded", () => {
                        document.querySelectorAll(".btn-detail-log").forEach(btn => {
                            btn.addEventListener("click", () => {
                                const jsonData = btn.dataset.json;
                                document.getElementById("log-json-view").textContent = jsonData;
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