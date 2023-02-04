<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg">

    <head>
        
        <meta charset="utf-8" />
        <title>Sign Up | {{ env('APP_NAME') }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Define app base url -->
        <base href="{{ env('APP_URL') }}/">

        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- Layout config Js -->
        <script src="assets/js/layout.js"></script>
        <!-- Bootstrap Css -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
        <!-- custom Css-->
        <link href="assets/css/custom.min.css" rel="stylesheet" type="text/css" />


    </head>

    <body>

        <!-- auth-page wrapper -->
        <div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
            <div class="bg-overlay"></div>
            <!-- auth-page content -->
            <div class="auth-page-content overflow-hidden pt-lg-5">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card overflow-hidden m-0">
                                <div class="row justify-content-center g-0">
                                    <div class="col-lg-6">
                                        <div class="p-lg-5 p-4 auth-one-bg h-100">
                                            <div class="bg-overlay"></div>
                                            <div class="position-relative h-100 d-flex flex-column">
                                                <div class="mb-4">
                                                    <a href="index.html" class="d-block">
                                                        <img src="assets/images/logo-light.png" alt="" height="18">
                                                    </a>
                                                </div>
                                                <div class="mt-auto">
                                                    <div class="mb-3">
                                                        <i class="ri-double-quotes-l display-4 text-success"></i>
                                                    </div>

                                                    <div id="qoutescarouselIndicators" class="carousel slide" data-bs-ride="carousel">
                                                        <div class="carousel-indicators">
                                                            <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="0" class="active"
                                                                aria-current="true" aria-label="Slide 1"></button>
                                                            <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="1"
                                                                aria-label="Slide 2"></button>
                                                            <button type="button" data-bs-target="#qoutescarouselIndicators" data-bs-slide-to="2"
                                                                aria-label="Slide 3"></button>
                                                        </div>
                                                        <div class="carousel-inner text-center text-white-50 pb-5">
                                                            <div class="carousel-item active">
                                                                <p class="fs-15 fst-italic">" Great and easy to use. Get your election results in seconds! "</p>
                                                            </div>
                                                            <div class="carousel-item">
                                                                <p class="fs-15 fst-italic">" The full election process is covered from candidate nominations, voter registration & voting. "</p>
                                                            </div>
                                                            <div class="carousel-item">
                                                                <p class="fs-15 fst-italic">" Multiple ballot elections are easy to set up. "</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- end carousel -->

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="p-lg-5 p-4">
                                   
                                            @if (isset($message))
                                            <div class="row mb-2 mt-2">
                                                <div class="alert alert-{{ $message['type'] }}" role="alert">
                                                    {!! $message['text'] !!}
                                                </div>
                                            </div>
                                            @endif 

                                            <div>
                                                <h5 class="text-primary">Register Account</h5>
                                                <p class="text-muted">Get your {{ env('APP_NAME') }} account now.</p>
                                            </div>
            
                                            <div class="mt-4">
                                                <form method="POST" action="{{ url('submit-signup') }}" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label class="form-label" for="user_full_name">Full Name<span class="text-danger">*</span></label>
                                                        <input type="text" name="user_full_name" id="user_full_name" placeholder="Enter your full name" required class="form-control">
                                                        <div class="invalid-feedback">
                                                            Required: Please enter your full name
                                                        </div>  
                                                     
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="user_email" class="form-label">Email <span class="text-danger">*</span></label>
                                                        <input type="email" class="form-control" name="user_email" id="user_email" placeholder="Enter email address" required>  
                                                        <div class="invalid-feedback">
                                                            Required: Please enter email
                                                        </div>      
                                                    </div>

                                                    <div class="mb-3">
                                                        
                                                        <label class="form-label" for="password-input">Password<span class="text-danger">*</span></label>
                                                        <div class="position-relative auth-pass-inputgroup mb-3">
                                                            <input type="password" name="password" class="form-control pe-5" placeholder="Enter password" id="password-input">
                                                            <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                                        </div>
                                                        <div class="invalid-feedback">
                                                            Required: Please enter password
                                                        </div>  


                                                        <!--
                                                        <label for="userpassword" class="form-label">Password <span class="text-danger">*</span></label>
                                                        <input type="password" class="form-control" name="password" id="userpassword" placeholder="Enter password" required>
                                                        <div class="invalid-feedback">
                                                            Required: Please enter password
                                                        </div>       
                                                        -->
                                                    </div>


                                                    <div class="mb-3">
                                                        <label class="form-label" for="user_company_name">Company Name</label>
                                                        <input type="text" name="user_company_name" id="user_company_name" placeholder="Represent an organization? Which one?" class="form-control">
                                                    
                                                    </div>
                                                    
                                                   
                                                    
        
                                                    <div class="mb-4">
                                                        <p class="mb-0 fs-12 text-muted fst-italic">By registering you agree to the  {{ env('APP_NAME', '') }} <a href="#" class="text-primary text-decoration-underline fst-normal fw-medium">Terms of Use</a></p>
                                                    </div>
                                                    
                                                    <div class="mt-4">
                                                        <button class="btn btn-success w-100" type="submit">Sign Up</button>
                                                    </div>
        
                                                   {{-- 
                                                   <div class="mt-4 text-center">
                                                        <div class="signin-other-title">
                                                            <h5 class="fs-13 mb-4 title text-muted">Create account with</h5>
                                                        </div>
        
                                                        <div>
                                                            <button type="button" class="btn btn-primary btn-icon waves-effect waves-light"><i class="ri-facebook-fill fs-16"></i></button>
                                                            <button type="button" class="btn btn-danger btn-icon waves-effect waves-light"><i class="ri-google-fill fs-16"></i></button>
                                                            <button type="button" class="btn btn-dark btn-icon waves-effect waves-light"><i class="ri-github-fill fs-16"></i></button>
                                                            <button type="button" class="btn btn-info btn-icon waves-effect waves-light"><i class="ri-twitter-fill fs-16"></i></button>
                                                        </div>
                                                    </div>
                                                    --}}
                                                </form>
                                            </div>
    
                                            <div class="mt-5 text-center">
                                                <p class="mb-0">Already have an account ? <a href="auth-signin-cover.html" class="fw-semibold text-primary text-decoration-underline"> Signin</a> </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
    
                    </div>
                    <!-- end row -->
                </div>
                <!-- end container -->
            </div>
            <!-- end auth page content -->

            <!-- footer -->
            <footer class="footer">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center">
                                <p class="mb-0">&copy; <script>document.write(new Date().getFullYear())</script> {{ env('APP_NAME', '') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->
        </div>
        <!-- end auth-page-wrapper -->

        <!-- JAVASCRIPT -->
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/node-waves/waves.min.js"></script>
        <script src="assets/libs/feather-icons/feather.min.js"></script>
        <script src="assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
        <script src="assets/js/plugins.js"></script>

        <!-- validation init -->
        <script src="assets/js/pages/form-validation.init.js"></script>
        <!-- password-addon init -->
        <script src="assets/js/pages/password-addon.init.js"></script>
    </body>

</html>