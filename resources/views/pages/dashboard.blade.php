<x-app-layout>
    <div class="container-fluid mt-2" id="main-content">
        <div class="row gx-3 gx-lg-4">
            <div class="col-12">
                <div class="card rounded adminuiux-card text-white bg-dark overflow-hidden mb-3 mb-lg-4">
                    <div class="card-body">
                        <h1 class="display-2 fw-medium mb-1">Lorem Ipsum</h1>
                        <p class="small opacity-75 mb-4">Lorem ipsum dolor sit amet
                            <span class="badge badge-sm text-bg-success"><i class="bi bi-arrow-up-short"></i>
                                00.0%</span> lorem ipsum
                        </p>
                        <div class="row gx-3 align-items-center">
                            <div class="col-auto"><a class="btn btn-square btn-outline-light" href="#" title="Lorem"><i
                                        class="bi bi-qr-code"></i></a></div>
                            <div class="col-auto"><a class="btn btn-square btn-outline-light" href="#" title="Lorem"><i
                                        class="bi bi-arrow-up-right"></i></a></div>
                            <div class="col-auto"><a class="btn btn-square btn-outline-light" href="#" title="Lorem"><i
                                        class="bi bi-arrow-down-left"></i></a></div>
                            <div class="col-auto"><a class="btn btn-square btn-outline-light" href="#" title="Lorem"><i
                                        class="bi bi-plus-lg"></i></a></div>
                        </div>
                    </div>
                </div>

                <div class="row gx-3 gx-lg-4">
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card adminuiux-card mb-3 mb-lg-4">
                            <div class="card-body">
                                <div class="row gx-3 align-items-center">
                                    <div class="col">
                                        <h6>Lorem Ipsum</h6>
                                    </div>
                                    <div class="col-auto"><a href="#" class="btn btn-sm btn-outline-theme"><i
                                                class="bi bi-arrow-up-right me-1"></i>Lorem</a></div>
                                    <div class="col-auto"><a href="#" class="btn btn-sm btn-link">Lorem</a>
                                    </div>
                                </div>
                            </div>
                            <ul class="list-group list-group-flush border-top bg-none">
                                <li class="list-group-item">
                                    <div class="row gx-3 align-items-center">
                                        <div class="col-auto">
                                            <div class="avatar avatar-40 rounded-circle border"><i
                                                    class="bi bi-arrow-up-right h5"></i></div>
                                        </div>
                                        <div class="col">
                                            <p class="mb-0 fw-medium">Lorem ipsum dolor</p>
                                            <p class="text-secondary small">Lorem ipsum</p>
                                        </div>
                                        <div class="col-auto">
                                            <h6>- Lorem</h6>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row gx-3 align-items-center">
                                        <div class="col-auto">
                                            <div class="avatar avatar-40 rounded-circle border"><i
                                                    class="bi bi-arrow-up-right h5"></i></div>
                                        </div>
                                        <div class="col">
                                            <p class="mb-0 fw-medium">Lorem ipsum dolor</p>
                                            <p class="text-secondary small">Lorem ipsum</p>
                                        </div>
                                        <div class="col-auto">
                                            <h6>- Lorem</h6>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item theme-green">
                                    <div class="row gx-3 align-items-center">
                                        <div class="col-auto">
                                            <div
                                                class="avatar avatar-40 rounded-circle border border-theme-1 bg-theme-1-subtle text-theme-1">
                                                <i class="bi bi-arrow-down-left h5"></i>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <p class="mb-0 fw-medium">Lorem ipsum dolor</p>
                                            <p class="text-secondary small">Lorem ipsum</p>
                                        </div>
                                        <div class="col-auto">
                                            <h6 class="text-theme-1">+ Lorem</h6>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row gx-3 align-items-center">
                                        <div class="col-auto">
                                            <div class="avatar avatar-40 rounded-circle border"><i
                                                    class="bi bi-arrow-up-right h5"></i></div>
                                        </div>
                                        <div class="col">
                                            <p class="mb-0 fw-medium">Lorem ipsum dolor</p>
                                            <p class="text-secondary small">Lorem ipsum</p>
                                        </div>
                                        <div class="col-auto">
                                            <h6>- Lorem</h6>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-12 col-lg-4">
                        <div class="row gx-3 gx-lg-4">
                            @foreach(range(1,4) as $item)
                            <div class="col-6 col-sm-6 col-lg-6 mb-3 mb-lg-4">
                                <div class="card adminuiux-card">
                                    <div class="card-body">
                                        <div class="row gx-3 gx-lg-4 mb-3">
                                            <div class="col"><i class="bi bi-cash-stack h2 rounded"></i></div>
                                            <div class="col-auto">
                                                <div class="dropdown">
                                                    <button class="btn btn-square btn-link dropdown-toggle no-caret"
                                                        type="button" data-bs-toggle="dropdown">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="#">Lorem</a></li>
                                                        <li><a class="dropdown-item" href="#">Lorem</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <h4 class="mb-0">Lorem ipsum</h4>
                                        <p class="text-secondary small mb-2">Lorem ipsum dolor sit amet</p>
                                        <span class="badge badge-light text-bg-success">
                                            <i class="me-1 bi bi-arrow-up-short"></i>00.00%
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-12 col-lg-4">
                        <div class="col-6 col-sm-12 col-lg-12">
                            <div class="card adminuiux-card mb-3 mb-lg-4">
                                <div class="card-header">
                                    <div class="row gx-3">
                                        <div class="col mb-3 mb-sm-0">
                                            <h4 class="mb-0">Lorem ipsum</h4>
                                            <p class="text-secondary small">Lorem ipsum dolor</p>
                                        </div>
                                        <div class="col-12 col-sm-auto text-center">
                                            <div class="avatar avatar-100 mx-auto">00%</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card adminuiux-card mb-3 mb-lg-4">
                            <div class="card-header">
                                <div class="row gx-3">
                                    <div class="col mb-3 mb-sm-0">
                                        <h4 class="mb-0">Lorem ipsum</h4>
                                        <p class="text-secondary small">Lorem ipsum dolor</p>
                                    </div>
                                    <div class="col-12 col-sm-auto text-center">
                                        <div class="avatar avatar-100 mx-auto">00%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>