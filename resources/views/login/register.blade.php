<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teckdor - Furniture Supplier No. 1 Indonesia</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon-img.png') }}" sizes="16x16">
    <!-- remix icon font css  -->
    <link rel="stylesheet" href="{{ asset('assets/css/remixicon.css') }}">
    <!-- BootStrap css -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/bootstrap.min.css') }}">
    <!-- Apex Chart css -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/apexcharts.css') }}">
    <!-- Data Table css -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/dataTables.min.css') }}">
    <!-- Text Editor css -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/editor-katex.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lib/editor.atom-one-dark.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lib/editor.quill.snow.css') }}">
    <!-- Date picker css -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/flatpickr.min.css') }}">
    <!-- Calendar css -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/full-calendar.css') }}">
    <!-- Vector Map css -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/jquery-jvectormap-2.0.5.css') }}">
    <!-- Popup css -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/magnific-popup.css') }}">
    <!-- Slick Slider css -->
    <link rel="stylesheet" href="{{ asset('assets/css/lib/slick.css') }}">
    <!-- main css -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body>

    <section class="auth bg-base d-flex flex-wrap">
        <div class="auth-left d-lg-block d-none">
            <div class="d-flex align-items-center flex-column h-100 justify-content-center">
                <img src="assets/images/banner-auth.png" alt="Banner" class="img-fluid">
            </div>
        </div>
        <div class="auth-right d-flex flex-column justify-content-center">
            <div class="max-w-464-px mx-auto w-auto">
                <div>
                    <a href="{{ route('login') }}" class="mb-40 max-w-290-px">
                        <img src="assets/images/teckdor.png" alt="">
                    </a>
                    <h4 class="mb-12">Sign Up to your Account</h4>
                    <p class="mb-32 text-secondary-light text-lg">Welcome back! Please sign in to your account</p>
                </div>

                @if ($errors->has('error'))
                    <div class="mb-16">
                        <div class="alert alert-info bg-danger-100 text-danger-600 border-danger-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-0 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between"
                            role="alert">
                            <div class="d-flex align-items-center gap-2">
                                <iconify-icon icon="mingcute:delete-2-line" class="icon text-xl"></iconify-icon>
                                <span>{{ $errors->first('error') }}</span>
                            </div>
                            <button class="remove-button text-danger-600 text-xxl line-height-1"> <iconify-icon
                                    icon="iconamoon:sign-times-light" class="icon"></iconify-icon></button>
                        </div>
                    </div>
                @endif

                <form action="{{ route('save-register') }}" method="POST" class="row gy-3 needs-validation"
                    novalidate>
                    @csrf

                    <div class="">
                        <div class="icon-field has-validation">
                            <span class="icon">
                                <iconify-icon icon="f7:person"></iconify-icon>
                            </span>
                            <input type="name" name="name" autocomplete="off"
                                class="form-control @error('name') is-invalid @enderror" placeholder="Name"
                                value="{{ old('name') }}">

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>
                    </div>

                    <div class="">
                        <div class="icon-field has-validation">
                            <span class="icon">
                                <iconify-icon icon="mage:email"></iconify-icon>
                            </span>
                            <input type="email" name="email" autocomplete="off"
                                class="form-control @error('email') is-invalid @enderror" placeholder="Email"
                                value="{{ old('email') }}">

                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>
                    </div>

                    <div class="">
                        <div class="icon-field has-validation">
                            <span class="icon">
                                <iconify-icon icon="solar:lock-password-outline"></iconify-icon>
                            </span>
                            <input type="password" name="password" autocomplete="off"
                                class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                                id="your-password" value="{{ old('password') }}">

                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <span
                                class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light"
                                data-toggle="#your-password"></span>

                        </div>
                    </div>

                    <div class="">
                        <div class="icon-field has-validation">
                            <div class="d-flex align-items-center flex-wrap gap-28">
                                <div class="form-check checked-danger d-flex align-items-center gap-2">
                                    <input class="form-check-input" type="radio" name="role" value="admin"
                                        id="horizontal1" checked>
                                    <label class="form-check-label line-height-1 fw-medium text-secondary-light"
                                        for="horizontal1"> Admin </label>
                                </div>
                                <div class="form-check checked-danger d-flex align-items-center gap-2">
                                    <input class="form-check-input" type="radio" name="role" value="customer"
                                        id="horizontal2">
                                    <label class="form-check-label line-height-1 fw-medium text-secondary-light"
                                        for="horizontal2"> Customer </label>
                                </div>
                                <div class="form-check checked-danger d-flex align-items-center gap-2">
                                    <input class="form-check-input" type="radio" name="role" value="finance"
                                        id="horizontal2">
                                    <label class="form-check-label line-height-1 fw-medium text-secondary-light"
                                        for="horizontal2"> Finance </label>
                                </div>
                            </div>

                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-danger text-sm btn-sm w-100">
                            Sign Up
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </section>

    <!-- jQuery library js -->
    <script src="{{ asset('assets/js/lib/jquery-3.7.1.min.js') }}"></script>
    <!-- Bootstrap js -->
    <script src="{{ asset('assets/js/lib/bootstrap.bundle.min.js') }}"></script>
    <!-- Apex Chart js -->
    <script src="{{ asset('assets/js/lib/apexcharts.min.js') }}"></script>
    <!-- Data Table js -->
    <script src="{{ asset('assets/js/lib/dataTables.min.js') }}"></script>
    <!-- Iconify Font js -->
    <script src="{{ asset('assets/js/lib/iconify-icon.min.js') }}"></script>
    <!-- jQuery UI js -->
    <script src="{{ asset('assets/js/lib/jquery-ui.min.js') }}"></script>
    <!-- Vector Map js -->
    <script src="{{ asset('assets/js/lib/jquery-jvectormap-2.0.5.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/jquery-jvectormap-world-mill-en.js') }}"></script>
    <!-- Popup js -->
    <script src="{{ asset('assets/js/lib/magnifc-popup.min.js') }}"></script>
    <!-- Slick Slider js -->
    <script src="{{ asset('assets/js/lib/slick.min.js') }}"></script>
    <!-- main js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <script>
        $('.remove-button').on('click', function() {
            $(this).closest('.alert').addClass('d-none')
        });
    </script>

    <script>
        // ================== Password Show Hide Js Start ==========
        function initializePasswordToggle(toggleSelector) {
            $(toggleSelector).on('click', function() {
                $(this).toggleClass("ri-eye-off-line");
                var input = $($(this).attr("data-toggle"));
                if (input.attr("type") === "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            });
        }
        // Call the function
        initializePasswordToggle('.toggle-password');
        // ========================= Password Show Hide Js End ===========================
    </script>

</body>

</html>
