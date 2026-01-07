{{-- resources/views/monitoring/resource.blade.php --}}
<x-app-layout>
    <div class="container-fluid mt-2" id="main-content">

        {{-- =========================== --}}
        {{-- Header Halaman --}}
        {{-- =========================== --}}
        <h4 class="fw-bold">{{ __('Resource Monitoring') }}</h4>
        <p class="text-muted">{{ __('Live usage information from server and application.') }}</p>

        {{-- ============================= --}}
        {{-- Resource Summary Cards --}}
        {{-- ============================= --}}
        <div class="row g-3 mt-3">

            {{-- CPU --}}
            <div class="col-md-3">
                <div class="card adminuiux-card mb-3 mb-lg-4">
                    <div class="card-header">
                        <div class="row gx-3">
                            <div class="col mb-3 mb-sm-0">
                                {{-- Judul dan deskripsi --}}
                                <h5 class="mb-0 fw-bold">{{ __('CPU Usage') }}</h5>
                                <p class="text-secondary small mb-0">{{ __('Current CPU load') }}</p>
                            </div>
                            <div class="col-12 col-sm-auto text-center">
                                {{-- Persentase CPU --}}
                                <h2>
                                    <div class="avatar avatar-100 mx-auto">{{ $cpu }}%</div>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RAM --}}
            <div class="col-md-3">
                <div class="card adminuiux-card mb-3 mb-lg-4">
                    <div class="card-header">
                        <div class="row gx-3">
                            <div class="col mb-3 mb-sm-0">
                                <h5 class="mb-0 fw-bold">{{ __('RAM Usage') }}</h5>
                                <p class="text-secondary small mb-0">{{ __('Memory utilization') }}</p>
                            </div>
                            <div class="col-12 col-sm-auto text-center">
                                <h2>
                                    <div class="avatar avatar-100 mx-auto">{{ $ram }}%</div>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Disk --}}
            <div class="col-md-3">
                <div class="card adminuiux-card mb-3 mb-lg-4">
                    <div class="card-header">
                        <div class="row gx-3">
                            <div class="col mb-3 mb-sm-0">
                                <h5 class="mb-0 fw-bold">{{ __('Disk Usage') }}</h5>
                                <p class="text-secondary small mb-0">{{ __('Storage consumption') }}</p>
                            </div>
                            <div class="col-12 col-sm-auto text-center">
                                <h2>
                                    <div class="avatar avatar-100 mx-auto">{{ $disk }}%</div>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Users --}}
            <div class="col-md-3">
                <div class="card adminuiux-card mb-3 mb-lg-4">
                    <div class="card-header">
                        <div class="row gx-3">
                            <div class="col mb-3 mb-sm-0">
                                <h5 class="mb-0 fw-bold">{{ __('Active Users') }}</h5>
                                <p class="text-secondary small mb-0">{{ __('Users currently active in system') }}</p>
                            </div>
                            <div class="col-12 col-sm-auto text-center">
                                <h2>
                                    <div class="avatar avatar-100 mx-auto ">{{ $users }}</div>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div> {{-- /row --}}


        {{-- ============================= --}}
        {{-- Resource Monitoring Table --}}
        {{-- ============================= --}}
        <div class="col-12">
            <div class="card adminuiux-card">
                <div class="card-body p-0">
                    <div class="p-4 mt-4">
                        <div class="table-responsive overflow-hidden">
                            <table id="datatables" class="table table-hover table-bordered w-100 nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th>{{ __('Resource') }}</th>
                                        <th>{{ __('Category') }}</th>
                                        <th>{{ __('Current Usage') }}</th>
                                        <th>{{ __('Limit / Capacity') }}</th>
                                        <th>{{ __('Updated At') }}</th>
                                        <th class="text-end">{{ __('Details') }}</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($resources as $item)
                                    <tr>
                                        <td>{{ $item['name'] }}</td>
                                        <td>{{ $item['category'] }}</td>
                                        <td>{{ $item['usage'] }}</td>
                                        <td>{{ $item['limit'] }}</td>
                                        <td>{{ $item['time'] }}</td>
                                        <td class="text-end">
                                            {{-- tombol view JSON --}}
                                            <button class="btn btn-link btn-sm text-dark btn-detail-log"
                                                data-json="{{ json_encode($item, JSON_PRETTY_PRINT) }}"
                                                data-bs-toggle="modal" data-bs-target="#detailLogModal">
                                                View
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============================= --}}
        {{-- Modal --}}
        {{-- ============================= --}}
        <div class="modal fade" id="detailLogModal" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content rounded-3">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Resource Detail') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
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

        {{-- ============================= --}}
        {{-- Script JSON Viewer --}}
        {{-- ============================= --}}
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
</x-app-layout>