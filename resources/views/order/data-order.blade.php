@extends('template.customer')

@section('customer-content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Order</h6>
        <ul class="d-flex align-items-center gap-2">

        </ul>
    </div>

    <div class="col-xxl-12">
        <div class="card p-0 overflow-hidden position-relative radius-12 h-100">
            <div
                class="card-header pt-16 pb-0 px-24 bg-base border border-end-0 border-start-0 border-top-0 d-flex align-items-center flex-wrap justify-content-between">
                <ul class="nav bordered-tab d-inline-flex nav-pills mb-0 w-100" id="pills-tab-six" role="tablist">
                    <li class="nav-item flex-grow-1" role="presentation">
                        <button class="nav-link px-16 py-10 active w-100" id="pills-header-home-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-header-home" type="button" role="tab"
                            aria-controls="pills-header-home" aria-selected="true">Order Submission</button>
                    </li>
                    <li class="nav-item flex-grow-1" role="presentation">
                        <button class="nav-link px-16 py-10 w-100" id="pills-header-details-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-header-details" type="button" role="tab"
                            aria-controls="pills-header-details" aria-selected="false">Order Confirmation</button>
                    </li>
                    <li class="nav-item flex-grow-1" role="presentation">
                        <button class="nav-link px-16 py-10 w-100" id="pills-header-profile-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-header-profile" type="button" role="tab"
                            aria-controls="pills-header-profile" aria-selected="false">Order Processing</button>
                    </li>
                    <li class="nav-item flex-grow-1" role="presentation">
                        <button class="nav-link px-16 py-10 w-100" id="pills-header-settings-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-header-settings" type="button" role="tab"
                            aria-controls="pills-header-settings" aria-selected="false">Order Finished</button>
                    </li>
                    <li class="nav-item flex-grow-1" role="presentation">
                        <button class="nav-link px-16 py-10 w-100" id="pills-shipping-settings-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-shipping-settings" type="button" role="tab"
                            aria-controls="pills-shipping-settings" aria-selected="false">Order Shipping</button>
                    </li>
                </ul>
            </div>

            <div class="card-body p-24 pt-10">
                <div class="tab-content" id="pills-tabContent-six">
                    <div class="tab-pane fade show active" id="pills-header-home" role="tabpanel"
                        aria-labelledby="pills-header-home-tab" tabindex="0">
                        <div>
                            @if (session()->has('success'))
                                <div class="mb-16">
                                    <div class="alert alert-success bg-success-100 text-success-600 border-success-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-0 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between"
                                        role="alert">
                                        <div class="d-flex align-items-center gap-2">
                                            <iconify-icon icon="akar-icons:double-check"
                                                class="icon text-xl"></iconify-icon>
                                            <span>{{ session()->get('success') }}</span>
                                        </div>
                                        <button class="remove-button text-success-600 text-xxl line-height-1"> <iconify-icon
                                                icon="iconamoon:sign-times-light" class="icon"></iconify-icon></button>
                                    </div>
                                </div>
                            @endif
                            @if (session()->has('deleted'))
                                <div class="mb-16">
                                    <div class="alert alert-danger bg-danger-100 text-danger-600 border-danger-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-0 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between"
                                        role="alert">
                                        <div class="d-flex align-items-center gap-2">
                                            <iconify-icon icon="mingcute:delete-2-line" class="icon text-xl"></iconify-icon>
                                            <span>{{ session()->get('deleted') }}</span>
                                        </div>
                                        <button class="remove-button text-danger-600 text-xxl line-height-1">
                                            <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon>
                                        </button>
                                    </div>
                                </div>
                            @endif

                            <form id="orderForm" action="{{ route('orders-update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div id="cart-container">
                                    @if ($order_submit->isEmpty())
                                        <!-- Tampilkan card kosong jika data tidak ada -->
                                        <div class="card basic-data-table mb-3 p-3">
                                            <div class="card-body text-center">
                                                <p class="text-muted">No products order available.</p>
                                            </div>
                                        </div>
                                    @else
                                        @foreach ($order_submit as $itemOrder)
                                            <div class="card basic-data-table mb-3 p-3">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <!-- Gambar dan detail produk -->
                                                        <div
                                                            class="d-flex flex-column align-items-end justify-content-center">
                                                            <img src="{{ asset('storage/' . $itemOrder->product->thumbnail) }}"
                                                                alt="Product Image" class="flex-shrink-0 me-3 radius-8"
                                                                style="width: 120px; height: 100px; object-fit: cover; border-radius: 8px; margin-left: 20px;">
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <span class="text-muted text-sm">Code.
                                                                {{ $itemOrder->code_order }}</span>
                                                            <h6 class="fw-medium mb-1">
                                                                {{ $itemOrder->product->name_product }}</h6>
                                                            <span class="text-muted">Order: {{ $itemOrder->qty }}
                                                                Set</span>
                                                        </div>
                                                        <div
                                                            class="d-flex flex-column align-items-end justify-content-between">
                                                            <div class="d-flex justify-content-between gap-1 w-100">
                                                                <!-- Tombol Order Now -->
                                                                <button type="button"
                                                                    class="btn btn-dark radius-8 d-flex align-items-center justify-content-center gap-2 order-now-btn"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#productModal{{ $itemOrder->id }}">
                                                                    <iconify-icon icon="icon-park-outline:view-grid-detail"
                                                                        class="menu-icon text-lg"></iconify-icon>
                                                                    <span>Order Detail</span>
                                                                </button>
                                                                <!-- Tombol Delete -->
                                                                <a href="{{ route('delete-order', $itemOrder->id) }}"
                                                                    class="btn btn-danger radius-8 d-flex align-items-center justify-content-center gap-2"
                                                                    onclick="return confirm('Are you sure want to delete product order ?')">
                                                                    <iconify-icon
                                                                        icon="material-symbols:cancel-outline-rounded"
                                                                        class="menu-icon text-lg"></iconify-icon>
                                                                    <span>Cancel</span>
                                                                </a>
                                                            </div>
                                                            <br>
                                                            <span class="text-muted mb-3 mx-3">
                                                                {{ \Carbon\Carbon::parse($itemOrder->updated_at)->format('d M Y') }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-header-details" role="tabpanel"
                        aria-labelledby="pills-header-details-tab" tabindex="0">
                        <div>
                            @if (session()->has('success'))
                                <div class="mb-16">
                                    <div class="alert alert-success bg-success-100 text-success-600 border-success-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-0 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between"
                                        role="alert">
                                        <div class="d-flex align-items-center gap-2">
                                            <iconify-icon icon="akar-icons:double-check"
                                                class="icon text-xl"></iconify-icon>
                                            <span>{{ session()->get('success') }}</span>
                                        </div>
                                        <button class="remove-button text-success-600 text-xxl line-height-1">
                                            <iconify-icon icon="iconamoon:sign-times-light"
                                                class="icon"></iconify-icon></button>
                                    </div>
                                </div>
                            @endif
                            @if (session()->has('deleted'))
                                <div class="mb-16">
                                    <div class="alert alert-danger bg-danger-100 text-danger-600 border-danger-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-0 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between"
                                        role="alert">
                                        <div class="d-flex align-items-center gap-2">
                                            <iconify-icon icon="mingcute:delete-2-line"
                                                class="icon text-xl"></iconify-icon>
                                            <span>{{ session()->get('deleted') }}</span>
                                        </div>
                                        <button class="remove-button text-danger-600 text-xxl line-height-1">
                                            <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon>
                                        </button>
                                    </div>
                                </div>
                            @endif

                            <form id="orderForm" action="{{ route('orders-update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div id="cart-container">
                                    @if ($order_confirm->isEmpty())
                                        <!-- Tampilkan card kosong jika data tidak ada -->
                                        <div class="card basic-data-table mb-3 p-3">
                                            <div class="card-body text-center">
                                                <p class="text-muted">No products order available.</p>
                                            </div>
                                        </div>
                                    @else
                                        @foreach ($order_confirm as $itemOrder)
                                            <div class="card basic-data-table mb-3 p-3">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <!-- Gambar dan detail produk -->
                                                        <div
                                                            class="d-flex flex-column align-items-end justify-content-center">
                                                            <img src="{{ asset('storage/' . $itemOrder->product->thumbnail) }}"
                                                                alt="Product Image" class="flex-shrink-0 me-3 radius-8"
                                                                style="width: 120px; height: 100px; object-fit: cover; border-radius: 8px; margin-left: 20px;">
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <span class="text-muted text-sm">Code.
                                                                {{ $itemOrder->code_order }}</span>
                                                            <h6 class="fw-medium mb-1">
                                                                {{ $itemOrder->product->name_product }}</h6>
                                                            <span class="text-muted text-sm">Total Payment :
                                                                {{ $itemOrder->qty }} Set X
                                                                Rp. {{ number_format($itemOrder->total_payment) }}</span>
                                                        </div>
                                                        <div
                                                            class="d-flex flex-column align-items-end justify-content-between">
                                                            <div class="d-flex justify-content-between gap-1 w-100">
                                                                <p class="text-lg">
                                                                    <b>Rp.
                                                                        {{ number_format($itemOrder->qty * $itemOrder->total_payment) }}</b>
                                                                </p>
                                                            </div>
                                                            <br>
                                                            {{-- <span class="text-muted mb-3 mx-3">
                                                                {{ \Carbon\Carbon::parse($itemOrder->updated_at)->diffForHumans() }}
                                                            </span> --}}
                                                            @if ($itemOrder->payment_status == 'Paid')
                                                                <span class="fw-medium">
                                                                    <span
                                                                        class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">
                                                                        Paid Payment
                                                                    </span>
                                                                </span>
                                                            @else
                                                                <span class="fw-medium">
                                                                    <span
                                                                        class="bg-danger-focus text-danger-main px-24 py-4 rounded-pill fw-medium text-sm">
                                                                        Unpaid Payment
                                                                    </span>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-header-profile" role="tabpanel"
                        aria-labelledby="pills-header-profile-tab" tabindex="0">
                        <div>
                            <div class="mb-16">
                                <form id="orderForm" action="{{ route('orders-update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div id="cart-container">
                                        @if ($order_progress->isEmpty())
                                            <!-- Tampilkan card kosong jika data tidak ada -->
                                            <div class="card basic-data-table mb-3 p-3">
                                                <div class="card-body text-center">
                                                    <p class="text-muted">No products order available.</p>
                                                </div>
                                            </div>
                                        @else
                                            @foreach ($order_progress as $itemOrder)
                                                <div class="card basic-data-table mb-3 p-3">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <!-- Gambar dan detail produk -->
                                                            <div
                                                                class="d-flex flex-column align-items-end justify-content-center">
                                                                <img src="{{ asset('storage/' . $itemOrder->product->thumbnail) }}"
                                                                    alt="Product Image"
                                                                    class="flex-shrink-0 me-3 radius-8"
                                                                    style="width: 120px; height: 100px; object-fit: cover; border-radius: 8px; margin-left: 20px;">
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <span class="text-muted text-sm">Code.
                                                                    {{ $itemOrder->code_order }}</span>
                                                                <h6 class="fw-medium mb-1">
                                                                    {{ $itemOrder->product->name_product }}</h6>
                                                                <span class="text-muted text-sm">Total Payment :
                                                                    <b>Rp.
                                                                        {{ number_format($itemOrder->qty * $itemOrder->total_payment) }}
                                                                    </b>
                                                                </span>
                                                            </div>
                                                            <div
                                                                class="d-flex flex-column align-items-end justify-content-between">
                                                                <div class="d-flex justify-content-between gap-4 w-100">
                                                                    <span class="text-sm">Status Order : </span>
                                                                </div>

                                                                <span class="fw-medium">
                                                                    <button type="button"
                                                                        class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#orderModal{{ $itemOrder->code_order }}">
                                                                        <!-- Sesuaikan dengan ID modal -->
                                                                        {{ $itemOrder->orderProgress->first()->name_progress ?? 'No Progress' }}
                                                                    </button>
                                                                </span>

                                                                {{-- 
                                                                @if ($itemOrder->payment_status == 'Paid')
                                                                    <span class="fw-medium">
                                                                        <span
                                                                            class="bg-danger-focus text-danger-main px-24 py-4 rounded-pill fw-medium text-sm">
                                                                            Paid Payment
                                                                        </span>
                                                                    </span>
                                                                @else
                                                                    <span class="fw-medium">
                                                                        <span
                                                                            class="bg-danger-focus text-danger-main px-24 py-4 rounded-pill fw-medium text-sm">
                                                                            Unpaid Payment
                                                                        </span>
                                                                    </span>
                                                                @endif --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-header-settings" role="tabpanel"
                        aria-labelledby="pills-header-settings-tab" tabindex="0">
                        <div>
                            <div class="mb-16">
                                <form id="orderForm" action="{{ route('orders-update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div id="cart-container">
                                        @if ($order_done->isEmpty())
                                            <!-- Tampilkan card kosong jika data tidak ada -->
                                            <div class="card basic-data-table mb-3 p-3">
                                                <div class="card-body text-center">
                                                    <p class="text-muted">No products order available.</p>
                                                </div>
                                            </div>
                                        @else
                                            @foreach ($order_done as $itemOrder)
                                                <div class="card basic-data-table mb-3 p-3">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <!-- Gambar dan detail produk -->
                                                            <div
                                                                class="d-flex flex-column align-items-end justify-content-center">
                                                                <img src="{{ asset('storage/' . $itemOrder->product->thumbnail) }}"
                                                                    alt="Product Image"
                                                                    class="flex-shrink-0 me-3 radius-8"
                                                                    style="width: 120px; height: 100px; object-fit: cover; border-radius: 8px; margin-left: 20px;">
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <span class="text-muted text-sm">Code.
                                                                    {{ $itemOrder->code_order }}</span>
                                                                <h6 class="fw-medium mb-1">
                                                                    {{ $itemOrder->product->name_product }}</h6>
                                                                <span class="text-muted text-sm">Total Payment :
                                                                    <b>Rp.
                                                                        {{ number_format($itemOrder->qty * $itemOrder->total_payment) }}
                                                                    </b>
                                                                </span>
                                                            </div>
                                                            <div
                                                                class="d-flex flex-column align-items-end justify-content-between">
                                                                <div class="d-flex justify-content-between gap-1 w-100">
                                                                    <span class="text-sm">Status Order : </span>
                                                                </div>

                                                                <span class="fw-medium">
                                                                    <button type="button"
                                                                        class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#orderModal{{ $itemOrder->code_order }}">
                                                                        <!-- Sesuaikan dengan ID modal -->
                                                                        {{ $itemOrder->orderProgress->first()->name_progress ?? 'No Progress' }}
                                                                    </button>
                                                                </span>
                                                                {{-- 
                                                                    @if ($itemOrder->payment_status == 'Paid')
                                                                        <span class="fw-medium">
                                                                            <span
                                                                                class="bg-danger-focus text-danger-main px-24 py-4 rounded-pill fw-medium text-sm">
                                                                                Paid Payment
                                                                            </span>
                                                                        </span>
                                                                    @else
                                                                        <span class="fw-medium">
                                                                            <span
                                                                                class="bg-danger-focus text-danger-main px-24 py-4 rounded-pill fw-medium text-sm">
                                                                                Unpaid Payment
                                                                            </span>
                                                                        </span>
                                                                    @endif --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-shipping-settings" role="tabpanel"
                        aria-labelledby="pills-shipping-settings-tab" tabindex="0">
                        <div>
                            <div class="mb-16">
                                <form id="orderForm" action="{{ route('orders-update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div id="cart-container">
                                        @if ($order_shipping->isEmpty())
                                            <!-- Tampilkan card kosong jika data tidak ada -->
                                            <div class="card basic-data-table mb-3 p-3">
                                                <div class="card-body text-center">
                                                    <p class="text-muted">No products order available.</p>
                                                </div>
                                            </div>
                                        @else
                                            @foreach ($order_shipping as $itemOrder)
                                                <div class="card basic-data-table mb-3 p-3">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <!-- Gambar dan detail produk -->
                                                            <div
                                                                class="d-flex flex-column align-items-end justify-content-center">
                                                                <img src="{{ asset('storage/' . $itemOrder->order->product->thumbnail) }}"
                                                                    alt="Product Image"
                                                                    class="flex-shrink-0 me-3 radius-8"
                                                                    style="width: 120px; height: 100px; object-fit: cover; border-radius: 8px; margin-left: 20px;">
                                                            </div>
                                                            <div class="flex-grow-1">
                                                                <span class="text-muted text-sm">Code.
                                                                    {{ $itemOrder->code_shipping }}</span>
                                                                <h6 class="fw-medium mb-1">
                                                                    {{ $itemOrder->order->product->name_product }}</h6>
                                                                <span class="text-muted text-sm">Total Payment :
                                                                    <b>Rp.
                                                                        {{ number_format($itemOrder->order->qty * $itemOrder->order->total_payment) }}
                                                                    </b>
                                                                </span>
                                                            </div>

                                                            <div
                                                                class="d-flex flex-column align-items-end justify-content-between">
                                                                <div class="d-flex justify-content-between gap-1 w-100">
                                                                    <span class="text-sm">Date Shipping : </span>
                                                                </div>

                                                                <span class="fw-medium">
                                                                    {{ $itemOrder->created_at->format('d M Y H:i:s') }}
                                                                </span>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    @foreach ($order_submit as $itemOrder)
        <!-- Modal Detail Product -->
        <div class="modal fade" id="productModal{{ $itemOrder->id }}" tabindex="-1"
            aria-labelledby="productModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="productModalLabel">Order Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <form action="{{ route('save-product') }}" method="POST" class="row gy-3 needs-validation"
                                enctype="multipart/form-data" novalidate>
                                @csrf

                                <div class="col-md-12">
                                    <label class="form-label">Product Sample</label>
                                    <div class="upload-image-wrapper d-flex align-items-center gap-3 w-100">
                                        <div
                                            class="uploaded-img position-relative w-100 h-100 border input-form-light radius-8 overflow-hidden border-dashed bg-neutral-50">
                                            <!-- Menampilkan gambar dari database -->
                                            @if ($itemOrder->img_sample && Storage::disk('public')->exists($itemOrder->img_sample))
                                                <img class="uploaded-img__preview w-100 h-100 object-fit-contain border rounded"
                                                    src="{{ asset('storage/' . $itemOrder->img_sample) }}"
                                                    alt="Image Sample">
                                            @else
                                                <div
                                                    class="d-flex align-items-center justify-content-center h-100 bg-light border rounded">
                                                    <p class="text-muted text-center mb-0">No image uploaded</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    @error('thumbnail')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Name Product</label>
                                    <input type="name" name="product_name"
                                        class="form-control @error('product_name') is-invalid @enderror"
                                        placeholder="Enter Product Name" value="{{ $itemOrder->product->name_product }}"
                                        readonly>

                                    @error('product_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Description</label>
                                    <textarea rows="10" type="text" name="description"
                                        class="form-control @error('description') is-invalid @enderror" placeholder="Enter Product Description"
                                        value="{{ old('description') }}" readonly>{{ $itemOrder->description }}</textarea>

                                    @error('description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Quantity</label>
                                    <input type="number" name="stock"
                                        class="form-control @error('stock') is-invalid @enderror"
                                        placeholder="Enter Stock" value="{{ number_format($itemOrder->qty) }}" readonly>

                                    @error('stock')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Length (Cm)</label>
                                    <input type="number" name="length"
                                        class="form-control @error('length') is-invalid @enderror"
                                        placeholder="Enter Length" value="{{ number_format($itemOrder->length) }}"
                                        readonly>

                                    @error('length')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Width (Cm)</label>
                                    <input type="number" name="width"
                                        class="form-control @error('width') is-invalid @enderror"
                                        placeholder="Enter Width" value="{{ number_format($itemOrder->width) }}"
                                        readonly>

                                    @error('width')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Height (Cm)</label>
                                    <input type="number" name="height"
                                        class="form-control @error('height') is-invalid @enderror"
                                        placeholder="Enter Height" value="{{ number_format($itemOrder->height) }}"
                                        readonly>

                                    @error('height')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($order_confirm as $itemOrder)
        <!-- Modal Detail Product -->
        <div class="modal fade" id="productModal{{ $itemOrder->id }}" tabindex="-1"
            aria-labelledby="productModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="productModalLabel">Order Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <form action="{{ route('save-product') }}" method="POST" class="row gy-3 needs-validation"
                                enctype="multipart/form-data" novalidate>
                                @csrf

                                <div class="col-md-12">
                                    <label class="form-label">Product Sample</label>
                                    <div class="upload-image-wrapper d-flex align-items-center gap-3 w-100">
                                        <div
                                            class="uploaded-img position-relative w-100 h-100 border input-form-light radius-8 overflow-hidden border-dashed bg-neutral-50">
                                            <!-- Menampilkan gambar dari database -->
                                            <img class="uploaded-img__preview w-100 h-100 object-fit-contain"
                                                src="{{ asset('storage/' . $itemOrder->img_sample) }}"
                                                alt="Image Sample">
                                        </div>
                                    </div>

                                    @error('thumbnail')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Name Product</label>
                                    <input type="name" name="product_name"
                                        class="form-control @error('product_name') is-invalid @enderror"
                                        placeholder="Enter Product Name" value="{{ $itemOrder->product->name_product }}"
                                        readonly>

                                    @error('product_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Description</label>
                                    <textarea rows="10" type="text" name="description"
                                        class="form-control @error('description') is-invalid @enderror" placeholder="Enter Product Description"
                                        value="{{ old('description') }}" readonly>{{ $itemOrder->description }}</textarea>

                                    @error('description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Quantity</label>
                                    <input type="number" name="stock"
                                        class="form-control @error('stock') is-invalid @enderror"
                                        placeholder="Enter Stock" value="{{ number_format($itemOrder->qty) }}" readonly>

                                    @error('stock')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Length (Cm)</label>
                                    <input type="number" name="length"
                                        class="form-control @error('length') is-invalid @enderror"
                                        placeholder="Enter Length" value="{{ number_format($itemOrder->length) }}"
                                        readonly>

                                    @error('length')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Width (Cm)</label>
                                    <input type="number" name="width"
                                        class="form-control @error('width') is-invalid @enderror"
                                        placeholder="Enter Width" value="{{ number_format($itemOrder->width) }}"
                                        readonly>

                                    @error('width')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Height (Cm)</label>
                                    <input type="number" name="height"
                                        class="form-control @error('height') is-invalid @enderror"
                                        placeholder="Enter Height" value="{{ number_format($itemOrder->height) }}"
                                        readonly>

                                    @error('height')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($order_progress_list as $orderItem)
        <div class="modal fade modal-lg" id="orderModal{{ $orderItem->code_order }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Status History</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($order_progress_list as $progress)
                                    @if ($progress->code_order == $orderItem->code_order)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $progress->name_progress }}</td>
                                            <td>{{ $progress->created_at->format('d F Y H:i:s') }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
