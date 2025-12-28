<div class="adminuiux-wrap">
    <!-- Standard sidebar -->
    <div class="adminuiux-sidebar shadow-sm">
        <div class="adminuiux-sidebar-inner">
            <ul class="nav flex-column menu-active-line mt-3">

                <!-- DASHBOARD -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link d-flex align-items-center {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="menu-icon bi bi-cpu me-2"></i>
                        <span class="menu-name">Dashboard</span>
                    </a>
                </li>
                <hr>
                <!-- SYSTEM CONFIGURATION -->
                <li class="nav-item dropdown">
                    <a href="javascript:void(0)" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="menu-icon bi bi-gear"></i>
                        <span class="menu-name">Configuration</span>
                    </a>
                    <div class="dropdown-menu">
                        <div class="nav-item">
                            <a href="{{ route('roles') }}" class="nav-link">
                                <i class="menu-icon bi bi-people"></i>
                                <span class="menu-name">Roles</span>
                            </a>
                        </div>

                        <div class="nav-item">
                            <a href="{{ route('permissions') }}" class="nav-link">
                                <i class="menu-icon bi bi-key"></i>
                                <span class="menu-name">Permissions</span>
                            </a>
                        </div>

                        <div class="nav-item">
                            <a href="{{ route('assign') }}" class="nav-link">
                                <i class="menu-icon bi bi-person-check"></i>
                                <span class="menu-name">User Assignment</span>
                            </a>
                        </div>
                    </div>
                </li>
                <!-- ACTION LOG -->
                <li class="nav-item">
                    <a href="{{ route('action-logs') }}"
                        class="nav-link d-flex align-items-center {{ request()->routeIs('action-logs') ? 'active' : '' }}">
                        <i class="menu-icon bi bi-journal-text me-2"></i>
                        <span class="menu-name">Action Log</span>
                    </a>
                </li>
                <!-- REPORT -->
                <!-- <li class="nav-item">
                    <a href=""
                        class="nav-link d-flex align-items-center {{ request()->routeIs('reports') ? 'active' : '' }}">
                        <i class="menu-icon bi bi-file-earmark-text me-2"></i>
                        <span class="menu-name">Report</span>
                    </a>
                </li> -->
                <!-- LOGOUT -->
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
                        confirmButtonColor: '#1e1e1e', // black solid button
                        cancelButtonColor: '#ffffff', // background transparent (CSS handles border)
                        confirmButtonText: 'Yes, Logout',
                        cancelButtonText: 'Cancel',
                        reverseButtons: false, // better UX: Cancel on the left
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('logout-form').submit();
                        }
                    });
                }
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
                                        <img src="assets/img/profile.png" alt="">
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