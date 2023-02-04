<html lang="en" data-layout="horizontal" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-layout-mode="light" data-layout-width="fluid" data-layout-position="fixed" data-layout-style="default"><script type="text/javascript" id="custom-useragent-string-page-script"></script><head>

    <meta charset="utf-8">
    <title>{{ $page_title }} | {{ env('APP_NAME', '') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Online Elections Made Easy" name="description" />
    <meta content="jamzykimani" name="author">

    <!-- Define app base url -->
    <base href="{{ env('APP_URL') }}/">
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Layout config Js -->
    <script src="assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css">
    <!-- custom Css-->
    <link href="assets/css/custom.min.css" rel="stylesheet" type="text/css">

</head>

<body style="">

    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar" class="">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="index.html" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="assets/images/logo-sm.png" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="assets/images/logo-dark.png" alt="" height="17">
                        </span>
                    </a>

                    <a href="index.html" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="assets/images/logo-sm.png" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="assets/images/logo-light.png" alt="" height="17">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>
            </div>

            <div class="d-flex align-items-center">

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-toggle="fullscreen">
                        <i class="bx bx-fullscreen fs-22"></i>
                    </button>
                </div>

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                        <i class="bx bx-moon fs-22"></i>
                    </button>
                </div>
               
                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user" src="assets/images/users/avatar-1.jpg" alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ session('user_full_name') }}</span>
                                <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">{{ session('user_category') }}</span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" style="">
                        <!-- item-->
                        <h6 class="dropdown-header">Welcome Anna!</h6>
                        <a class="dropdown-item" href="pages-profile.html"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Profile</span></a>
                        <a class="dropdown-item" href="apps-chat.html"><i class="mdi mdi-message-text-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Messages</span></a>
                        <a class="dropdown-item" href="apps-tasks-kanban.html"><i class="mdi mdi-calendar-check-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Taskboard</span></a>
                        <a class="dropdown-item" href="pages-faqs.html"><i class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Help</span></a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="pages-profile.html"><i class="mdi mdi-wallet text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Balance : <b>$5971.67</b></span></a>
                        <a class="dropdown-item" href="pages-profile-settings.html"><span class="badge bg-soft-success text-success mt-1 float-end">New</span><i class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Settings</span></a>
                        <a class="dropdown-item" href="auth-lockscreen-basic.html"><i class="mdi mdi-lock text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Lock screen</span></a>
                        <a class="dropdown-item" href="auth-logout-basic.html"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Logout</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
        <!-- ========== App Menu ========== -->
        <div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <!-- Dark Logo-->
                <a href="index.html" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="assets/images/logo-sm.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="assets/images/logo-dark.png" alt="" height="17">
                    </span>
                </a>
                <!-- Light Logo-->
                <a href="index.html" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="assets/images/logo-sm.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="assets/images/logo-light.png" alt="" height="17">
                    </span>
                </a>
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>

            <div id="scrollbar">
                <div class="container-fluid">

                    <div id="two-column-menu">
                    </div>
                    <ul class="navbar-nav" id="navbar-nav">
                        <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                        <li class="nav-item">
                            <a class="nav-link menu-link active" href="{{ url('list-elections') }}"><i class="ri-pages-line"></i> Elections </a>
                        </li>
                    </ul>
                </div>
                <!-- Sidebar -->
            </div>

            <div class="sidebar-background"></div>
        </div>
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    @if (!empty($message))
                    <div class="row mb-2 mt-2">
                        <div class="alert alert-{{ $message['type'] }}" role="alert">
                            {!! $message['text'] !!}
                        </div>
                    </div>
                    @endif 
                
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">{{ $page_title }}</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Elections</a></li>
                                        <li class="breadcrumb-item active">{{ $page_title }}</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    @if($hide_create_election === true)
                    <div class="row g-4 mb-3">
                        
                        <div class="col-sm-auto">
                            <div>
                                <a href="{{ url('list-elections', [], ['new' => true ])}}" class="btn btn-success"><i class="ri-add-line align-bottom me-1"></i>Create New Election</a>
                            </div>
                        </div>
                        
                        <div class="col-sm">
                            <div class="d-flex justify-content-sm-end gap-2">
                                <!--
                                <div class="search-box ms-2">
                                    <input type="text" class="form-control" placeholder="Search...">
                                    <i class="ri-search-line search-icon"></i>
                                </div>

                                <div class="choices" data-type="select-one" tabindex="0" role="listbox" aria-haspopup="true" aria-expanded="false"><div class="choices__inner"><select class="form-control w-md choices__input" data-choices="" data-choices-search-false="" hidden="" tabindex="-1" data-choice="active"><option value="Yesterday" data-custom-properties="[object Object]">Yesterday</option></select><div class="choices__list choices__list--single"><div class="choices__item choices__item--selectable" data-item="" data-id="1" data-value="Yesterday" data-custom-properties="[object Object]" aria-selected="true">Yesterday</div></div></div><div class="choices__list choices__list--dropdown" aria-expanded="false"><div class="choices__list" role="listbox"><div id="choices--jphi-item-choice-1" class="choices__item choices__item--choice choices__item--selectable is-highlighted" role="option" data-choice="" data-id="1" data-value="All" data-select-text="Press to select" data-choice-selectable="" aria-selected="true">All</div><div id="choices--jphi-item-choice-2" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="2" data-value="Last 7 Days" data-select-text="Press to select" data-choice-selectable="">Last 7 Days</div><div id="choices--jphi-item-choice-3" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="3" data-value="Last 30 Days" data-select-text="Press to select" data-choice-selectable="">Last 30 Days</div><div id="choices--jphi-item-choice-4" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="4" data-value="Last Year" data-select-text="Press to select" data-choice-selectable="">Last Year</div><div id="choices--jphi-item-choice-5" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="5" data-value="This Month" data-select-text="Press to select" data-choice-selectable="">This Month</div><div id="choices--jphi-item-choice-6" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="6" data-value="Today" data-select-text="Press to select" data-choice-selectable="">Today</div><div id="choices--jphi-item-choice-7" class="choices__item choices__item--choice is-selected choices__item--selectable" role="option" data-choice="" data-id="7" data-value="Yesterday" data-select-text="Press to select" data-choice-selectable="">Yesterday</div></div></div></div>
                                -->
                            </div>
                        </div>
                        
                    </div>

                    <div class="row">
                        @foreach ($elections as $el)
                        <div class="col-xxl-3 col-sm-6 project-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="p-3 mt-n3 mx-n3 bg-soft-info rounded-top">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <h5 class="mb-0 fs-14"><a href="{{ url('election-dashboard',[ 'election_code' => $el['election_code'] ]) }}" class="text-dark">{{ $el['election_title'] }}</a></h5>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div class="d-flex gap-1 align-items-center my-n2">
                                                    {{-- <button type="button" class="btn avatar-xs p-0 favourite-btn">
                                                        <span class="avatar-title bg-transparent fs-15">
                                                            <i class="ri-star-fill"></i>
                                                        </span>
                                                    </button> --}}
                                                    <div class="dropdown">
                                                        <button class="btn btn-link text-muted p-1 mt-n1 py-0 text-decoration-none fs-15" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal icon-sm"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                                        </button>

                                                        <div class="dropdown-menu dropdown-menu-end">
                                                            <a class="dropdown-item" href="#"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View Report</a>
                                                            <a class="dropdown-item" href="#"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#removeProjectModal"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Remove</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                  

                                    <div class="py-3">
                                        
                                        <div class="row gy-3">
                                            <div class="col-6">
                                                <div>
                                                <p class="text-muted mb-1">Status</p>
                                                @if ( time() < strtotime($el['election_start_date']) )
                                                    <div class="badge badge-soft-warning fs-12">Pre-Election</div>
                                                @elseif(time() > strtotime($el['election_start_date']) && time() < strtotime($el['election_end_date']) )
                                                    <div class="badge badge-soft-success fs-12">Ongoing</div>
                                                @else
                                                    <div class="badge badge-soft-danger fs-12">Closed</div>
                                                @endif
                                                    
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div>
                                                    <p class="text-muted mb-1">Start Date</p>
                                                    <h5 class="fs-14">{{ date('d M, Y', strtotime($el['election_start_date'])) }}</h5>
                                                </div>
                                            </div>
                                        </div>

                                        
                                    </div>
                                    <div>
                                        <div class="d-flex mb-2">
                                            <div class="flex-grow-1">
                                                <div>Voter Turnout</div>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <div><i class="ri-list-check align-bottom me-1 text-muted"></i> 0/20 (0%) </div>
                                            </div>
                                        </div>
                                        <div class="progress progress-sm animated-progress">
                                            <div class="progress-bar bg-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div><!-- /.progress-bar -->
                                        </div><!-- /.progress -->
                                    </div>

                                </div>
                                <!-- end card body -->
                                <div class="card-footer bg-transparent border-top-dashed py-2">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div>
                                                <a href="{{ url('election-dashboard',[ 'election_code' => $el['election_code'] ]) }}" class="btn btn-success">Manage Election</a>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <!-- end card footer -->
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                        @endforeach

                    </div>
                    <!-- end row -->
                    @else
                    <div class="row g-4 mb-3">
                        
                        <div class="col-sm-auto">
                            <div>
                                <a href="{{ url('list-elections')}}" class="btn btn-success"><i class="ri-arrow-left-s-line align-bottom me-1"></i> Back</a>
                            </div>
                        </div>
                        
                        <div class="col-sm">
                            <div class="d-flex justify-content-sm-end gap-2">
                                <!--
                                <div class="search-box ms-2">
                                    <input type="text" class="form-control" placeholder="Search...">
                                    <i class="ri-search-line search-icon"></i>
                                </div>

                                <div class="choices" data-type="select-one" tabindex="0" role="listbox" aria-haspopup="true" aria-expanded="false"><div class="choices__inner"><select class="form-control w-md choices__input" data-choices="" data-choices-search-false="" hidden="" tabindex="-1" data-choice="active"><option value="Yesterday" data-custom-properties="[object Object]">Yesterday</option></select><div class="choices__list choices__list--single"><div class="choices__item choices__item--selectable" data-item="" data-id="1" data-value="Yesterday" data-custom-properties="[object Object]" aria-selected="true">Yesterday</div></div></div><div class="choices__list choices__list--dropdown" aria-expanded="false"><div class="choices__list" role="listbox"><div id="choices--jphi-item-choice-1" class="choices__item choices__item--choice choices__item--selectable is-highlighted" role="option" data-choice="" data-id="1" data-value="All" data-select-text="Press to select" data-choice-selectable="" aria-selected="true">All</div><div id="choices--jphi-item-choice-2" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="2" data-value="Last 7 Days" data-select-text="Press to select" data-choice-selectable="">Last 7 Days</div><div id="choices--jphi-item-choice-3" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="3" data-value="Last 30 Days" data-select-text="Press to select" data-choice-selectable="">Last 30 Days</div><div id="choices--jphi-item-choice-4" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="4" data-value="Last Year" data-select-text="Press to select" data-choice-selectable="">Last Year</div><div id="choices--jphi-item-choice-5" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="5" data-value="This Month" data-select-text="Press to select" data-choice-selectable="">This Month</div><div id="choices--jphi-item-choice-6" class="choices__item choices__item--choice choices__item--selectable" role="option" data-choice="" data-id="6" data-value="Today" data-select-text="Press to select" data-choice-selectable="">Today</div><div id="choices--jphi-item-choice-7" class="choices__item choices__item--choice is-selected choices__item--selectable" role="option" data-choice="" data-id="7" data-value="Yesterday" data-select-text="Press to select" data-choice-selectable="">Yesterday</div></div></div></div>
                                -->
                            </div>
                        </div>
                        
                    </div>
                    

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <form method="POST" action="{{ url('create-election') }}" >
                                @csrf
                                <div class="card-header">
                                    <h6 class="card-title mb-0"><i class="ri-pages-line align-middle me-1 lh-1"></i> Create a New Election</h6>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted">Fill out the form below and save the details to create an election.</p>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="election_title" class="form-label">Election Title</label>
                                                <input type="hidden" required name="election_code" id="election_code" value="{{ uniqid('e_') }}" >
                                                <input type="text" required name="election_title" class="form-control" placeholder="Enter title" id="election_title">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="election_start_date" class="form-label">Start Date</label>
                                                <input id="election_start_date" name="election_start_date" type="text" class="form-control flatpickr-input active" data-provider="flatpickr" data-date-format="Y-m-d H:i" data-enable-time="" readonly="readonly">
                                            </div>
                                        </div>
                                   
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="election_end_date" class="form-label">End Date</label>
                                                <input id="election_end_date" name="election_end_date" type="text" class="form-control flatpickr-input active" data-provider="flatpickr" data-date-format="Y-m-d H:i" data-enable-time="" readonly="readonly">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="election_timezone" class="form-label">Timezone</label>
                                            <select class="form-select" data-choices data-choices-sorting="true" id="election_timezone" name="election_timezone">
                                                <option selected>Choose...</option>
                                                <option value="Africa/Nairobi">Nairobi (GMT+3)</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="card-footer">
                                    <div class="hstack gap-2">
                                        <button type="submit" class="btn btn-success">Save</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>document.write(new Date().getFullYear())</script> © {{ env('APP_NAME', 'Election System') }}.
                        </div>
                        <div class="col-sm-6">
                            <!--<div class="text-sm-end d-none d-sm-block">
                                Design &amp; Develop by 
                            </div>-->
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- removeProjectModal -->
    <div id="removeProjectModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mt-2 text-center">
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                            <h4>Are you Sure ?</h4>
                            <p class="text-muted mx-4 mb-0">Are you Sure You want to Remove this Project ?</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn w-sm btn-danger" id="remove-project">Yes, Delete It!</button>
                    </div>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->



    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top" style="display: none;">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->



    <!-- JAVASCRIPT -->
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/libs/feather-icons/feather.min.js"></script>
    <script src="assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="assets/js/plugins.js"></script><script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script type="text/javascript" src="assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
    <script type="text/javascript" src="assets/libs/flatpickr/flatpickr.min.js"></script>


    <!-- project list init -->
    <script src="assets/js/pages/project-list.init.js"></script>

    <!-- App js -->
    <script src="assets/js/app.js"></script>

    <script>

    flatpickr("#election_start_date", {enableTime: true});
    flatpickr("#election_end_date", {enableTime: true});
    </script>


</body></html>