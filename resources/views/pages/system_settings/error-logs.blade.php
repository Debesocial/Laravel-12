<x-app-layout>
    <div class="container-fluid mt-2" id="main-content">
        <div class="row gx-3 gx-lg-4">
            <div class="col-12">
                <div class="card adminuiux-card">
                    <div class="card-body p-0">

                        {{-- header halaman action log --}}
                        <div class="p-4 pb-0">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h5 class="mb-0 fw-bold">{{ __('Error Log') }}</h5>
                                    <small class="text-muted">
                                        {{ __('Monitor all recorded user actions within the system, including authentication, CRUD activities, and administrative events.') }}
                                    </small>
                                </div>
                            </div>
                        </div>

                        {{-- tabel action log --}}
                        <div class="p-4">

                            {{-- FILTER FORM + DOWNLOAD + CLEAR (1 ROW) --}}
                            <form action="{{ route('error-logs') }}" method="GET" class="row g-3 mb-4 align-items-end">

                                {{-- Date Filter --}}
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">{{ __('Filter by Date') }}</label>
                                    <input type="date" name="date" class="form-control" value="{{ request('date') }}"
                                        placeholder="YYYY-MM-DD">
                                </div>

                                {{-- Apply --}}
                                <div class="col-md-2">
                                    <button class="btn btn-primary w-100">{{ __('Apply Filters') }}</button>
                                </div>

                                {{-- Reset --}}
                                <div class="col-md-2">
                                    <a href="{{ route('error-logs') }}"
                                        class="btn btn-outline-dark w-100">{{ __('Reset') }}</a>
                                </div>

                                {{-- Download --}}
                                <div class="col-md-2">
                                    <a href="{{ route('error-logs.download') }}"
                                        class="btn btn-info w-100">{{ __('Download') }}</a>
                                </div>

                                {{-- Clear --}}
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger w-100" id="clear-logs-btn">
                                        {{ __('Clear') }}
                                    </button>
                                </div>

                            </form>

                            {{-- Script SweetAlert untuk Clear --}}
                            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                            <script>
                            document.getElementById('clear-logs-btn').addEventListener('click', function() {
                                Swal.fire({
                                    title: '{{ __("Are you sure?") }}',
                                    text: '{{ __("This action will clear all logs!") }}',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#d33',
                                    cancelButtonColor: '#3085d6',
                                    confirmButtonText: '{{ __("Yes, clear it!") }}'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        const form = document.createElement('form');
                                        form.method = 'POST';
                                        form.action = "{{ route('error-logs.clear') }}";
                                        const csrf = document.createElement('input');
                                        csrf.type = 'hidden';
                                        csrf.name = '_token';
                                        csrf.value = '{{ csrf_token() }}';
                                        form.appendChild(csrf);
                                        document.body.appendChild(form);
                                        form.submit();
                                    }
                                });
                            });
                            </script>

                            {{-- LOG CONTENT --}}
                            <div class="border rounded bg-dark p-3" style="height: 70vh; overflow:auto">
                                @forelse($content as $line)
                                @php
                                $class = 'text-light';
                                if (str_contains($line, 'ERROR')) $class = 'text-danger fw-bold';
                                elseif (str_contains($line, 'WARNING')) $class = 'text-warning fw-bold';
                                elseif (str_contains($line, 'INFO')) $class = 'text-info fw-bold';
                                @endphp
                                <div class="{{ $class }}" style="font-family: monospace; font-size:14px;">
                                    {{ $line }}
                                </div>
                                @empty
                                <p class="text-secondary">{{ __('No log data for this filter.') }}</p>
                                @endforelse
                            </div>
                            {{-- PAGINATION --}}
                            <div class="mt-3 d-flex justify-content-between">
                                @php $p = request('page',1); @endphp
                                <a href="{{ request()->fullUrlWithQuery(['page'=>max($p-1,1)]) }}"
                                    class="btn btn-outline-dark px-5">Prev</a>
                                <a href="{{ request()->fullUrlWithQuery(['page'=>$p+1]) }}"
                                    class="btn btn-outline-dark px-5">Next</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>