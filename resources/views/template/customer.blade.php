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
    <aside class="sidebar">
        <button type="button" class="sidebar-close-btn">
            <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
        </button>
        <div>
            <a href="#" class="sidebar-logo">
                <img src="{{ asset('assets/images/teckdor.png') }}" alt="site logo" class="light-logo">
                <img src="{{ asset('assets/images/teckdor-dark.png') }}" alt="site logo" class="dark-logo">
                <img src="{{ asset('assets/images/teckdor.png') }}" alt="site logo" class="logo-icon">
            </a>
        </div>
        <div class="sidebar-menu-area">

            <ul class="sidebar-menu" id="sidebar-menu">
                <li>
                    <a href="{{ route('customer-dashboard') }}">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                        <span>Home</span>
                    </a>
                </li>

                <li class="sidebar-menu-group-title">Application</li>

                <li>
                    <a href="{{ route('data-cart') }}">
                        <iconify-icon icon="solar:cart-check-broken" class="menu-icon"></iconify-icon>
                        <span>Carts</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('data-order') }}">
                        <iconify-icon icon="material-symbols:order-approve-outline-rounded"
                            class="menu-icon"></iconify-icon>
                        <span>Orders</span>
                    </a>
                </li>

                {{-- <li class="sidebar-menu-group-title">Settings</li>

                <li>
                    <a href="{{ route('data-product') }}">
                        <iconify-icon icon="solar:user-broken" class="menu-icon"></iconify-icon>
                        <span>Account</span>
                    </a>
                </li> --}}

            </ul>
        </div>
    </aside>

    <main class="dashboard-main">
        <div class="navbar-header">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto">
                    <div class="d-flex flex-wrap align-items-center gap-4">
                        <button type="button" class="sidebar-toggle">
                            <iconify-icon icon="heroicons:bars-3-solid" class="icon text-2xl non-active"></iconify-icon>
                            <iconify-icon icon="iconoir:arrow-right" class="icon text-2xl active"></iconify-icon>
                        </button>
                        <button type="button" class="sidebar-mobile-toggle">
                            <iconify-icon icon="heroicons:bars-3-solid" class="icon"></iconify-icon>
                        </button>
                        <form class="navbar-search">
                            <input type="text" name="search" placeholder="Search">
                            <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                        </form>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <button type="button" data-theme-toggle
                            class="w-40-px h-40-px bg-neutral-200 rounded-circle d-flex justify-content-center align-items-center"></button>

                        <div class="dropdown">
                            <button class="d-flex justify-content-center align-items-center rounded-circle"
                                type="button" data-bs-toggle="dropdown">
                                <img src="{{ asset('assets/images/user_icon2.png') }}" width="40px" alt="image"
                                    class="w-40-px h-40-px object-fit-cover rounded-circle">
                            </button>
                            <div class="dropdown-menu to-top dropdown-menu-sm">
                                <div
                                    class="py-12 px-16 radius-8 bg-danger-50 mb-16 d-flex align-items-center justify-content-between gap-2">
                                    <div>
                                        <h6 class="text-lg text-primary-light fw-semibold mb-2">
                                            {{ Auth::user()->name }}</h6>
                                        <span
                                            class="text-secondary-light fw-medium text-sm">{{ Auth::user()->email }}</span>
                                    </div>
                                    <button type="button" class="hover-text-danger">
                                        <iconify-icon icon="radix-icons:cross-1" class="icon text-xl"></iconify-icon>
                                    </button>
                                </div>
                                <ul class="to-top-list">
                                    {{-- <li>
                                        <a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-primary d-flex align-items-center gap-3"
                                            href="view-profile.html">
                                            <iconify-icon icon="solar:user-linear"
                                                class="icon text-xl"></iconify-icon> My Profile</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-primary d-flex align-items-center gap-3"
                                            href="email.html">
                                            <iconify-icon icon="mynaui:cart-check"
                                                class="icon text-xl"></iconify-icon> Carts</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-primary d-flex align-items-center gap-3"
                                            href="company.html">
                                            <iconify-icon icon="material-symbols:order-approve-outline-rounded"
                                                class="icon text-xl"></iconify-icon> Orders</a>
                                    </li> --}}
                                    <li>
                                        <a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-primary d-flex align-items-center gap-3"
                                            href="{{ route('logout') }}"
                                            onclick="confirm('Are you sure you want to logout?')">
                                            <iconify-icon icon="solar:logout-linear"
                                                class="icon text-xl"></iconify-icon> Logout</a>
                                    </li>
                                </ul>
                            </div>
                        </div><!-- Profile dropdown end -->
                    </div>
                </div>
            </div>
        </div>

        <div class="dashboard-main-body">

            {{-- konten utama --}}
            @yield('customer-content')

        </div>

        <footer class="d-footer">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto text-center">
                    <p class="mb-0">© 2025 TecD'or. All Rights Reserved.</p>
                </div>
                {{-- <div class="col-auto">
                    <p class="mb-0">Made by <span class="text-primary-600">wowtheme7</span></p>
                </div> --}}
            </div>
        </footer>
    </main>

    <!-- jQuery library js -->
    <script src="{{ asset('assets/js/lib/jquery-3.7.1.min.js') }}"></script>
    <!-- Bootstrap js -->
    <script src="{{ asset('assets/js/lib/bootstrap.bundle.min.js') }}"></script>
    <!-- Apex Chart js -->
    {{-- <script src="{{ asset('assets/js/lib/apexcharts.min.js') }}"></script> --}}
    <!-- Data Table js -->
    <script src="{{ asset('assets/js/lib/dataTables.min.js') }}"></script>
    <!-- Iconify Font js -->
    <script src="{{ asset('assets/js/lib/iconify-icon.min.js') }}"></script>
    <!-- jQuery UI js -->
    <script src="{{ asset('assets/js/lib/jquery-ui.min.js') }}"></script>
    <!-- Vector Map js -->
    {{-- <script src="{{ asset('assets/js/lib/jquery-jvectormap-2.0.5.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/jquery-jvectormap-world-mill-en.js') }}"></script> --}}
    <!-- Popup js -->
    <script src="{{ asset('assets/js/lib/magnifc-popup.min.js') }}"></script>
    <!-- Slick Slider js -->
    <script src="{{ asset('assets/js/lib/slick.min.js') }}"></script>
    <!-- main js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>

    {{-- <script src="{{ asset('assets/js/homeThreeChart.js') }}"></script> --}}

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Delegasi event untuk input file
            document.body.addEventListener("change", function(e) {
                if (e.target.classList.contains("upload-input")) {
                    const fileInput = e.target;
                    const uploadWrapper = fileInput.closest(".upload-image-wrapper");
                    const uploadedImgContainer = uploadWrapper.querySelector(".uploaded-img");
                    const imagePreview = uploadedImgContainer.querySelector(".uploaded-img__preview");

                    if (fileInput.files.length) {
                        const src = URL.createObjectURL(fileInput.files[0]);
                        imagePreview.src = src;
                        uploadedImgContainer.classList.remove("d-none");
                    }
                }
            });

            // Delegasi event untuk tombol hapus gambar
            document.body.addEventListener("click", function(e) {
                if (e.target.closest(".uploaded-img__remove")) {
                    const removeButton = e.target.closest(".uploaded-img__remove");
                    const uploadWrapper = removeButton.closest(".upload-image-wrapper");
                    const fileInput = uploadWrapper.querySelector(".upload-input");
                    const uploadedImgContainer = uploadWrapper.querySelector(".uploaded-img");
                    const imagePreview = uploadedImgContainer.querySelector(".uploaded-img__preview");

                    // Reset semua elemen terkait
                    imagePreview.src = "";
                    uploadedImgContainer.classList.add("d-none");
                    fileInput.value = "";
                }
            });

            // Tambahkan fitur drag and drop
            document.body.addEventListener("dragover", function(e) {
                e.preventDefault(); // Mencegah perilaku default browser
                if (e.target.closest(".upload-image-wrapper")) {
                    const uploadWrapper = e.target.closest(".upload-image-wrapper");
                    uploadWrapper.classList.add("dragging");
                }
            });

            document.body.addEventListener("dragleave", function(e) {
                if (e.target.closest(".upload-image-wrapper")) {
                    const uploadWrapper = e.target.closest(".upload-image-wrapper");
                    uploadWrapper.classList.remove("dragging");
                }
            });

            document.body.addEventListener("drop", function(e) {
                e.preventDefault(); // Mencegah perilaku default browser
                const uploadWrapper = e.target.closest(".upload-image-wrapper");

                if (uploadWrapper) {
                    const fileInput = uploadWrapper.querySelector(".upload-input");
                    const uploadedImgContainer = uploadWrapper.querySelector(".uploaded-img");
                    const imagePreview = uploadedImgContainer.querySelector(".uploaded-img__preview");
                    const files = e.dataTransfer.files; // File yang di-drag & drop

                    if (files.length) {
                        fileInput.files = files; // Set file input
                        const src = URL.createObjectURL(files[0]);
                        imagePreview.src = src;
                        uploadedImgContainer.classList.remove("d-none");
                    }

                    uploadWrapper.classList.remove("dragging"); // Hapus efek drag
                }
            });
        });
    </script>

    <script>
        let table = new DataTable('#dataTable');
    </script>

    <script>
        $('.remove-button').on('click', function() {
            $(this).closest('.alert').addClass('d-none')
        });
    </script>

</body>

</html>
