<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="{{asset('/vendors/base/vendor.bundle.base.css')}}">
    <script
        src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
        integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI="
        crossorigin="anonymous"></script>
    <!-- endinject -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{asset('/css/style.css')}}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{asset('/images/favicon.png')}}"/>
    
    <!-- Custom Color Scheme -->
    <style>
        :root {
            --primary-blue: #248afd;
            --water-blue: #17a2b8;
            --slate: #5a5c69;
        }
        /* Background colors */
        .bg-primary-blue { background-color: var(--primary-blue) !important; }
        .bg-water-blue { background-color: var(--water-blue) !important; }
        .bg-slate { background-color: var(--slate) !important; }
        
        /* Text colors */
        .text-primary-blue { color: var(--primary-blue) !important; }
        .text-water-blue { color: var(--water-blue) !important; }
        .text-slate { color: var(--slate) !important; }
        
        /* Buttons */
        .btn-water-blue { 
            background-color: var(--water-blue); 
            border-color: var(--water-blue); 
            color: white; 
        }
        .btn-water-blue:hover { 
            background-color: #138496; 
            border-color: #117a8b; 
            color: white;
        }
        .btn-outline-water-blue {
            color: var(--water-blue);
            border-color: var(--water-blue);
            background-color: transparent;
        }
        .btn-outline-water-blue:hover {
            background-color: var(--water-blue);
            color: white;
        }
        .btn-slate { 
            background-color: var(--slate); 
            border-color: var(--slate); 
            color: white; 
        }
        .btn-slate:hover { 
            background-color: #484a54; 
            border-color: #3d3f47; 
            color: white;
        }
        
        /* Badges */
        .badge-primary-blue { background-color: var(--primary-blue); color: white; }
        .badge-water-blue { background-color: var(--water-blue); color: white; }
        .badge-slate { background-color: var(--slate); color: white; }
        
        /* Progress bars */
        .progress-bar-primary-blue { background-color: var(--primary-blue); }
        .progress-bar-water-blue { background-color: var(--water-blue); }
        
        /* Avatar colors using our palette */
        .avatar-primary-blue { background-color: var(--primary-blue) !important; }
        .avatar-water-blue { background-color: var(--water-blue) !important; }
        
        /* Navbar Header Color */
        .navbar .navbar-brand-wrapper,
        .container-scroller .navbar .navbar-brand-wrapper,
        nav.navbar .navbar-brand-wrapper {
            background: #248afd !important;
        }
        .navbar .navbar-menu-wrapper {
            background: #248afd !important;
        }
        .navbar .navbar-brand-wrapper .navbar-brand,
        .navbar .navbar-brand-wrapper .navbar-brand.brand-logo,
        .navbar .navbar-brand-wrapper .navbar-brand.brand-logo-mini {
            color: white !important;
        }
        .navbar .navbar-menu-wrapper .ti-view-list,
        .navbar .navbar-menu-wrapper .navbar-nav .nav-item .nav-link {
            color: white !important;
        }
        
        /* Sidebar Styles - Same color as header */
        .sidebar {
            background: #248afd !important;
            position: fixed !important;
            top: 70px;
            left: 0;
            height: calc(100vh - 70px);
            overflow-y: auto;
            z-index: 999;
        }
        .sidebar .nav .nav-item .nav-link {
            color: rgba(255, 255, 255, 0.85) !important;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }
        .sidebar .nav .nav-item .nav-link:hover {
            background: rgba(255, 255, 255, 0.15) !important;
            color: #fff !important;
            border-left-color: #fff;
        }
        .sidebar .nav .nav-item .nav-link.active,
        .sidebar .nav .nav-item.active > .nav-link {
            background: rgba(255, 255, 255, 0.2) !important;
            color: #fff !important;
            border-left-color: #fff;
        }
        .sidebar .nav .nav-item .nav-link .menu-icon {
            color: #fff !important;
            font-size: 1.1rem;
            margin-right: 12px;
        }
        .sidebar .nav .nav-item .nav-link .menu-title {
            font-weight: 500;
            font-size: 0.9rem;
        }
        .sidebar .nav .nav-item .nav-link .menu-arrow {
            color: rgba(255, 255, 255, 0.7);
        }
        .sidebar .nav .nav-item .nav-link:hover .menu-arrow {
            color: #fff;
        }
        .sidebar .nav.sub-menu {
            background: rgba(0, 0, 0, 0.1);
            padding: 10px 0;
        }
        .sidebar .nav.sub-menu .nav-item .nav-link {
            padding: 10px 20px 10px 50px;
            font-size: 0.85rem;
            color: #fff !important;
            border-left: none !important;
        }
        .sidebar .nav.sub-menu .nav-item .nav-link:hover {
            color: #fff !important;
            background: rgba(255, 255, 255, 0.1) !important;
        }
        .sidebar .nav.sub-menu .nav-item .nav-link.active,
        .sidebar .nav.sub-menu .nav-item.active .nav-link {
            color: #fff !important;
            background: rgba(255, 255, 255, 0.15) !important;
            font-weight: 600;
        }
        .sidebar .nav.sub-menu .nav-item .nav-link::before {
            content: "•";
            margin-right: 10px;
            color: #fff;
        }
        
        /* Sidebar layout for fixed bottom section */
        .sidebar {
            display: flex;
            flex-direction: column;
        }
        .sidebar .nav {
            flex: 1;
            overflow-y: auto;
            padding-bottom: 20px;
        }
        
        /* Sidebar Bottom Section */
        .sidebar-bottom {
            background: rgba(0, 0, 0, 0.2);
            padding: 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            flex-shrink: 0;
        }
        .sidebar-bottom .user-info {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 12px;
            color: #fff;
        }
        .sidebar-bottom .user-info i {
            font-size: 1.5rem;
            margin-bottom: 5px;
        }
        .sidebar-bottom .user-info span {
            font-weight: 600;
            font-size: 0.9rem;
        }
        .sidebar-bottom .user-info small {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.75rem;
        }
        .sidebar-bottom .logout-btn {
            width: 100%;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #fff;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
        }
        .sidebar-bottom .logout-btn:hover {
            background: rgba(255, 255, 255, 0.25);
        }
        
        /* Main content area - offset for fixed sidebar */
        .main-panel {
            margin-left: 237px !important;
            width: calc(100% - 237px) !important;
        }
        @media (max-width: 991px) {
            .main-panel {
                margin-left: 0 !important;
                width: 100% !important;
            }
        }
        
        /* Footer Styles - Light gray separate from sidebar */
        .footer {
            background: #f4f5f7 !important;
            color: #5a5c69 !important;
            border-top: 1px solid #e3e6f0 !important;
            margin-left: 237px;
        }
        @media (max-width: 991px) {
            .footer {
                margin-left: 0;
            }
        }
        .footer span,
        .footer a {
            color: #5a5c69 !important;
        }
        
        /* Table Styles - Clean without highlight colors */
        .table {
            background: #fff;
        }
        .table thead th {
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: #5a5c69;
            padding: 12px 15px;
        }
        .table tbody tr {
            background: #fff !important;
        }
        .table tbody tr:hover {
            background: #f8f9fa !important;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background: #fff !important;
        }
        .table-striped tbody tr:nth-of-type(even) {
            background: #fafbfc !important;
        }
        .table td {
            padding: 12px 15px;
            vertical-align: middle;
            border-bottom: 1px solid #eee;
        }
        
        /* Action Buttons - Styled Icons */
        .action-btn {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 3px;
            border: none;
            transition: all 0.2s ease;
        }
        .action-btn-view {
            background: #e3f2fd;
            color: #1976d2;
        }
        .action-btn-view:hover {
            background: #1976d2;
            color: #fff;
        }
        .action-btn-edit {
            background: #fff3e0;
            color: #f57c00;
        }
        .action-btn-edit:hover {
            background: #f57c00;
            color: #fff;
        }
        .action-btn-delete {
            background: #ffebee;
            color: #d32f2f;
        }
        .action-btn-delete:hover {
            background: #d32f2f;
            color: #fff;
        }
        
        /* Search and Filter Buttons */
        .btn-search {
            background: #248afd;
            color: #fff;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
            font-weight: 500;
        }
        .btn-search:hover {
            background: #1a6fcc;
            color: #fff;
        }
        .btn-reset {
            background: #6c757d;
            color: #fff;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
            font-weight: 500;
        }
        .btn-reset:hover {
            background: #5a6268;
            color: #fff;
        }
    </style>
</head>
<body>
<div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center" style="background: #248afd !important;">
            <a class="navbar-brand brand-logo me-5" href="/">
                <span style="color: white; font-weight: bold; font-size: 1.5rem;">SMS</span>
            </a>
            <a class="navbar-brand brand-logo-mini" href="/">
                <span style="color: white; font-weight: bold; font-size: 1rem;">SMS</span>
            </a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end" style="background: #248afd !important;">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                <span class="ti-view-list"></span>
            </button>
            <ul class="navbar-nav mr-lg-2">
{{--                <li class="nav-item nav-search d-none d-lg-block">
                    <div class="input-group">
                        <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
                <span class="input-group-text" id="search">
                 <i class="ti-search"></i>
                </span>
                        </div>
                        <input type="text" class="form-control" id="navbar-search-input" placeholder="Search now"
                               aria-label="search" aria-describedby="search">
                    </div>
                </li>--}}
            </ul>
            <ul class="navbar-nav navbar-nav-right">
{{--                <li class="nav-item dropdown me-1">
                    <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center"
                       id="messageDropdown" href="#" data-bs-toggle="dropdown">
                        <i class="ti-email mx-0"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="messageDropdown">
                        <p class="mb-0 font-weight-normal float-left dropdown-header">Messages</p>
                        <a class="dropdown-item">
                            <div class="item-thumbnail">
                                <img src="images/faces/face4.jpg" alt="image" class="profile-pic">
                            </div>
                            <div class="item-content flex-grow">
                                <h6 class="ellipsis font-weight-normal">David Grey
                                </h6>
                                <p class="font-weight-light small-text text-muted mb-0">
                                    The meeting is cancelled
                                </p>
                            </div>
                        </a>
                        <a class="dropdown-item">
                            <div class="item-thumbnail">
                                <img src="images/faces/face2.jpg" alt="image" class="profile-pic">
                            </div>
                            <div class="item-content flex-grow">
                                <h6 class="ellipsis font-weight-normal">Tim Cook
                                </h6>
                                <p class="font-weight-light small-text text-muted mb-0">
                                    New product launch
                                </p>
                            </div>
                        </a>
                        <a class="dropdown-item">
                            <div class="item-thumbnail">
                                <img src="images/faces/face3.jpg" alt="image" class="profile-pic">
                            </div>
                            <div class="item-content flex-grow">
                                <h6 class="ellipsis font-weight-normal"> Johnson
                                </h6>
                                <p class="font-weight-light small-text text-muted mb-0">
                                    Upcoming board meeting
                                </p>
                            </div>
                        </a>
                    </div>
                </li>--}}
{{--                <li class="nav-item dropdown">
                    <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#"
                       data-bs-toggle="dropdown">
                        <i class="ti-bell mx-0"></i>
                        <span class="count"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                         aria-labelledby="notificationDropdown">
                        <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
                        <a class="dropdown-item">
                            <div class="item-thumbnail">
                                <div class="item-icon bg-success">
                                    <i class="ti-info-alt mx-0"></i>
                                </div>
                            </div>
                            <div class="item-content">
                                <h6 class="font-weight-normal">Application Error</h6>
                                <p class="font-weight-light small-text mb-0 text-muted">
                                    Just now
                                </p>
                            </div>
                        </a>
                        <a class="dropdown-item">
                            <div class="item-thumbnail">
                                <div class="item-icon bg-warning">
                                    <i class="ti-settings mx-0"></i>
                                </div>
                            </div>
                            <div class="item-content">
                                <h6 class="font-weight-normal">Settings</h6>
                                <p class="font-weight-light small-text mb-0 text-muted">
                                    Private message
                                </p>
                            </div>
                        </a>
                        <a class="dropdown-item">
                            <div class="item-thumbnail">
                                <div class="item-icon bg-info">
                                    <i class="ti-user mx-0"></i>
                                </div>
                            </div>
                            <div class="item-content">
                                <h6 class="font-weight-normal">New user registration</h6>
                                <p class="font-weight-light small-text mb-0 text-muted">
                                    2 days ago
                                </p>
                            </div>
                        </a>
                    </div>
                </li>--}}
                <li class="nav-item nav-profile dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
                        Hi! {{auth()->user()->name}}
                        <img src="{{url('/images/'.auth()->user()->photo_path)}}" alt="profile"/>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a class="dropdown-item" href="route('logout')"
                                                   onclick="event.preventDefault();
                                        this.closest('form').submit();">
                                <i class="ti-power-off">
                                {{ __('Log Out') }}</i>
                            </a>
                        </form>
                    </div>
                </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="offcanvas">
                <span class="ti-view-list"></span>
            </button>
        </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <!-- partial:partials -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav" style="padding-top: 15px;">
                <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                    <a class="nav-link" href="/">
                        <i class="ti-dashboard menu-icon"></i>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>
                
                <li class="nav-item {{ request()->is('classroom*') ? 'active' : '' }}">
                    <a class="nav-link" data-bs-toggle="collapse" href="#ui-classroom" aria-expanded="{{ request()->is('classroom*') ? 'true' : 'false' }}"
                       aria-controls="ui-classroom">
                        <i class="ti-home menu-icon"></i>
                        <span class="menu-title">Classrooms</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse {{ request()->is('classroom*') ? 'show' : '' }}" id="ui-classroom">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"><a class="nav-link" href="/classroom/create">Add Classroom</a></li>
                            <li class="nav-item"><a class="nav-link" href="/classroom">All Classrooms</a></li>
                        </ul>
                    </div>
                </li>
                
                <li class="nav-item {{ request()->is('teacher*') ? 'active' : '' }}">
                    <a class="nav-link" data-bs-toggle="collapse" href="#ui-teacher" aria-expanded="{{ request()->is('teacher*') ? 'true' : 'false' }}"
                       aria-controls="ui-teacher">
                        <i class="ti-briefcase menu-icon"></i>
                        <span class="menu-title">Teachers</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse {{ request()->is('teacher*') ? 'show' : '' }}" id="ui-teacher">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"><a class="nav-link" href="/teacher/create">Add Teacher</a></li>
                            <li class="nav-item"><a class="nav-link" href="/teacher">All Teachers</a></li>
                        </ul>
                    </div>
                </li>
                
                <li class="nav-item {{ request()->is('student*') ? 'active' : '' }}">
                    <a class="nav-link" data-bs-toggle="collapse" href="#ui-student" aria-expanded="{{ request()->is('student*') ? 'true' : 'false' }}"
                       aria-controls="ui-student">
                        <i class="ti-id-badge menu-icon"></i>
                        <span class="menu-title">Students</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse {{ request()->is('student*') ? 'show' : '' }}" id="ui-student">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"><a class="nav-link" href="/student/create">Add Student</a></li>
                            <li class="nav-item"><a class="nav-link" href="/student">All Students</a></li>
                        </ul>
                    </div>
                </li>
                
                <li class="nav-item {{ request()->is('subject*') ? 'active' : '' }}">
                    <a class="nav-link" data-bs-toggle="collapse" href="#ui-subject" aria-expanded="{{ request()->is('subject*') ? 'true' : 'false' }}"
                       aria-controls="ui-subject">
                        <i class="ti-book menu-icon"></i>
                        <span class="menu-title">Subjects</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse {{ request()->is('subject*') ? 'show' : '' }}" id="ui-subject">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"><a class="nav-link" href="/subject/create">Add Subject</a></li>
                            <li class="nav-item"><a class="nav-link" href="/subject">All Subjects</a></li>
                        </ul>
                    </div>
                </li>
                
                <li class="nav-item {{ request()->is('manager*') ? 'active' : '' }}">
                    <a class="nav-link" data-bs-toggle="collapse" href="#users" aria-expanded="{{ request()->is('manager*') ? 'true' : 'false' }}"
                       aria-controls="users">
                        <i class="ti-user menu-icon"></i>
                        <span class="menu-title">Users</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse {{ request()->is('manager*') ? 'show' : '' }}" id="users">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"><a class="nav-link" href="/manager/create">Add Manager</a></li>
                            <li class="nav-item"><a class="nav-link" href="/manager">All Users</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
            
            <!-- Sidebar Bottom Section - User Info & Logout -->
            <div class="sidebar-bottom">
                <div class="user-info">
                    <i class="ti-user"></i>
                    <span>{{ Auth::user()->name ?? 'User' }}</span>
                    <small>Administrator</small>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="ti-power-off"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </nav>
        <!-- partial -->

        @yield('content')

        <!-- main-panel ends -->

    </div>
    <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->

<!-- partial:partials/footer -->
<footer class="footer" style="background: #f4f5f7 !important; border-top: 1px solid #e3e6f0 !important;">
    <div class="d-sm-flex justify-content-center justify-content-sm-between">
        <span class="text-center text-sm-left d-block d-sm-inline-block" style="color: #5a5c69 !important;">Copyright © <strong>Petercodes</strong> 2026</span>
    </div>
</footer>
<!-- partial -->


<script type="text/javascript">
    $(function () {
        // Multiple images preview with JavaScript
        var multiImgPreview = function (input, imgPreviewPlaceholder) {
            if (imgPreviewPlaceholder.files) {
                imgPreviewPlaceholder.files.clear();
            }
            if (input.files) {
                var filesAmount = input.files.length;
                for (i = 0; i < filesAmount; i++) {
                    var reader = new FileReader();
                    reader.onload = function (event) {
                        var $clone = $($.parseHTML('<img>'));
                        $clone.attr('class', 'image_pr');
                        $clone.attr('style', 'max-width: 200px;');
                        $clone.attr('src', event.target.result).appendTo(imgPreviewPlaceholder);
                    }
                    reader.readAsDataURL(input.files[i]);

                }
            }
        };
        $('#images').on('change', function () {
            multiImgPreview(this, 'div.preview-image');
        });
        $('#photo').on('change', function () {
            // To delete the uploaded photo from preview after selecting new photo
            var arr = document.getElementsByClassName('image_pr');
            if (arr.length) {
                for (var i = 0; i < arr.length; i++) {
                    arr[i].remove();
                }
            }
            multiImgPreview(this, 'div.preview-image');
        });
    });

</script>
<!-- plugins:js -->

<script src="{{asset('vendors/base/vendor.bundle.base.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js" type="text/javascript"></script>

<!-- Custom js for dashboard-->
<script src="{{asset('js/off-canvas.js')}}"></script>
<script src="{{asset('js/hoverable-collapse.js')}}"></script>
<script src="{{asset('js/template.js')}}"></script>
<script src="{{asset('js/chart.js')}}"></script>
<script src="{{asset('js/file-upload.js')}}"></script>
<!-- End custom js for dashboard-->



</body>

</html>
