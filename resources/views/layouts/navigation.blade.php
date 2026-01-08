<div class="adminuiux-wrap">
    {{-- Standard sidebar --}}
    <div class="adminuiux-sidebar shadow-sm">
        <div class="adminuiux-sidebar-inner">
            <ul class="nav flex-column menu-active-line mt-3">

                {{-- DASHBOARD --}}
                @can('view dashboard')
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link d-flex align-items-center {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="menu-icon bi bi-cpu me-2"></i>
                        <span class="menu-name">Dashboard</span>
                    </a>
                </li>
                @endcan

                <hr>

                {{-- SYSTEM SETTINGS --}}
                @canany([
                'view system config',
                'view sessions',
                'view resource monitoring',
                'view error logs'
                ])
                <li class="nav-item dropdown">
                    <a href="javascript:void(0)" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="menu-icon bi bi-sliders"></i>
                        <span class="menu-name">System Settings</span>
                    </a>
                    <div class="dropdown-menu">

                        @can('view system config')
                        <div class="nav-item">
                            <a href="{{ route('system-config') }}" class="nav-link">
                                <i class="menu-icon bi bi-gear me-2"></i>
                                <span class="menu-name">System Config</span>
                            </a>
                        </div>
                        @endcan

                        @can('view sessions')
                        <div class="nav-item">
                            <a href="{{ route('session-manager') }}" class="nav-link">
                                <i class="menu-icon bi bi-clock-history me-2"></i>
                                <span class="menu-name">Session Manager</span>
                            </a>
                        </div>
                        @endcan

                        @can('view resource monitoring')
                        <div class="nav-item">
                            <a href="{{ route('resource-monitoring') }}" class="nav-link">
                                <i class="menu-icon bi bi-bar-chart me-2"></i>
                                <span class="menu-name">Resource Monitor</span>
                            </a>
                        </div>
                        @endcan

                        @can('view error logs')
                        <div class="nav-item">
                            <a href="{{ route('error-logs') }}" class="nav-link">
                                <i class="menu-icon bi bi-exclamation-triangle me-2"></i>
                                <span class="menu-name">Error Log</span>
                            </a>
                        </div>
                        @endcan

                    </div>
                </li>
                @endcanany

                {{-- ACCESS CONTROL --}}
                @canany([
                'view users',
                'view roles',
                'view permissions',
                'view action logs'
                ])
                <li class="nav-item dropdown">
                    <a href="javascript:void(0)" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="menu-icon bi bi-journal-text"></i>
                        <span class="menu-name">Access Control</span>
                    </a>
                    <div class="dropdown-menu">

                        @can('view action logs')
                        <div class="nav-item">
                            <a href="{{ route('action-logs') }}" class="nav-link">
                                <i class="menu-icon bi bi-journal-text me-2"></i>
                                <span class="menu-name">Action Log</span>
                            </a>
                        </div>
                        @endcan

                        @can('view roles')
                        <div class="nav-item">
                            <a href="{{ route('roles') }}" class="nav-link">
                                <i class="menu-icon bi bi-people"></i>
                                <span class="menu-name">Roles</span>
                            </a>
                        </div>
                        @endcan

                        @can('view permissions')
                        <div class="nav-item">
                            <a href="{{ route('permissions') }}" class="nav-link">
                                <i class="menu-icon bi bi-key"></i>
                                <span class="menu-name">Permissions</span>
                            </a>
                        </div>
                        @endcan

                        @can('view users')
                        <div class="nav-item">
                            <a href="{{ route('users') }}" class="nav-link">
                                <i class="menu-icon bi bi-person-check"></i>
                                <span class="menu-name">User Management</span>
                            </a>
                        </div>
                        @endcan

                    </div>
                </li>
                @endcanany

                {{-- LOGOUT --}}
                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link d-flex align-items-center text-danger"
                        onclick="confirmLogout();">
                        <i class="menu-icon bi bi-box-arrow-right me-2"></i>
                        <span class="menu-name">Logout</span>
                    </a>
                </li>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

                <script>
                function confirmLogout() {
                    Swal.fire({
                        title: 'Confirm Logout',
                        text: 'Are you sure you want to log out from your session?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#1e1e1e',
                        cancelButtonColor: '#ffffff',
                        confirmButtonText: 'Yes, Logout',
                        cancelButtonText: 'Cancel',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('logout-form').submit();
                        }
                    });
                }
                </script>

                {{-- IMPERSONATE WARNING --}}
                @if(session()->has('impersonator_id'))
                <div class="alert alert-warning text-center rounded mt-3">
                    {{ __('You are acting on behalf of another user. Please proceed with caution.') }}

                    <form id="stop-impersonate-form" method="POST" action="{{ route('impersonate.stop') }}"
                        class="d-inline">
                        @csrf
                        <button type="button" id="stop-impersonate-btn" class="form-control btn btn-sm btn-dark mt-2">
                            {{ __('Return to Original Account') }}
                        </button>
                    </form>
                </div>
                @endif

                <script>
                document.getElementById('stop-impersonate-btn')?.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.getElementById('stop-impersonate-form').submit();
                });
                </script>

            </ul>

            <div class=" mt-auto "></div>

            <div class="container mt-3 mt-lg-4" id="main-content" style="margin-top: 0rem !important;">
                <div class="row gx-3 align-items-center ms-4">
                    <div class="col mb-3 mb-lg-4">
                        <div class="row gx-2 align-items-center">
                            <div class="col-auto col-md-auto text-center">
                                <a href="{{ route('profile.edit') }}" class="style-none position-relative d-block">
                                    <figure class="avatar avatar-50 rounded coverimg align-middle">
                                        <img src="{{ asset('assets/img/profile.png') }}" alt="">
                                    </figure>
                                </a>
                            </div>
                            <div class="col">
                                <h5 class="fw-medium mb-0">Hello,</h5>
                                <h3><span class="text-theme-1">{{ Auth::user()->name ?? 'User' }}</span></h3>
                            </div>
                            <div class="col-auto text-end mb-3 mb-lg-4">
                                <a href="mobileux-wallet-sendmoney.html" class="style-none">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>