@extends('template.customer')

@section('customer-content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Detail Product</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="fluent-mdl2:product" class="icon text-lg"></iconify-icon>
                    Product
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Detail Product</li>
        </ul>
    </div>

    <div class="row gy-4">
        <div class="col-lg-12">
            <div class="card">
                {{-- <div class="card-header">
                <h5 class="card-title mb-0">Input Custom Styles</h5>
            </div> --}}
                <div class="card-body">
                    <form id="orderForm" action="{{ route('order-product') }}" method="POST"
                        class="row gy-3 needs-validation" enctype="multipart/form-data" novalidate>
                        @csrf

                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="col-md-12">
                            <section class="splide" aria-label="Splide Basic HTML Example">
                                <div class="splide__track">
                                    <ul class="splide__list">

                                        @foreach ($product->images as $dataImage)
                                            <li class="splide__slide"
                                                style="width: 400px; height: 400px; overflow: hidden;">
                                                <img src="{{ asset('storage/' . $dataImage->img_product) }}" alt=""
                                                    style="width: 100%; height: 100%; object-fit: cover; object-position: center; display: block;">
                                            </li>
                                        @endforeach

                                    </ul>
                                </div>
                            </section>

                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <!-- Nama Produk & Stok di Kiri -->
                            <div class="d-flex flex-column">
                                <h4 class="mb-0">{{ $product->name_product }}</h4>
                                <span class="mb-0">
                                    <strong>Stock:</strong>
                                    {{ ($product->product_stocks_sum_stock ?? 0) + ($product->stock ?? 0) + ($product->orders_sum_qty ?? 0) }}
                                    Set
                                </span>
                            </div>

                            <!-- Harga di Kanan -->
                            {{-- <h5 class="text-danger mb-0">{{ 'Rp. ' . number_format($product->price) ?? 'Rp. 0' }}</h5> --}}
                        </div>

                        <div class="col-md-12">
                            <hr>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Description</label>
                            <p class="text-justify">{{ $product->description }}</p>
                        </div>

                        <div class="col-md-12">
                            <hr>
                        </div>

                        <div class="col-md-3">
                            <span>Length : {{ number_format($product->length) }} Cm</span>
                        </div>
                        <div class="col-md-3">
                            <span>Width : {{ number_format($product->width) }} Cm</span>
                        </div>
                        <div class="col-md-3">
                            <span>Height : {{ number_format($product->height) }} Cm</span>
                        </div>
                        <div class="col-md-3">
                            <span>Weight : {{ number_format($product->weight) }} Kg</span>
                        </div>

                        <div class="col-md-12">
                            <hr>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Quantity</label>
                            <input type="number" name="qty" class="form-control @error('qty') is-invalid @enderror"
                                min="0" placeholder="Enter Quantity" value="{{ old('qty') }}">

                            @error('qty')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Order Description</label>
                            <textarea rows="5" type="text" name="desc_order" class="form-control @error('desc_order') is-invalid @enderror"
                                placeholder="Enter Order Description" value="{{ old('desc_order') }}"></textarea>
                            @error('desc_order')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Length (Cm)</label>
                            <input type="number" name="length" class="form-control @error('length') is-invalid @enderror"
                                placeholder="Enter Length" value="{{ old('length') }}">

                            @error('length')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Width (Cm)</label>
                            <input type="number" name="width" class="form-control @error('width') is-invalid @enderror"
                                placeholder="Enter Width" value="{{ old('width') }}">

                            @error('width')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Height (Cm)</label>
                            <input type="number" name="height" class="form-control @error('height') is-invalid @enderror"
                                placeholder="Enter Height" value="{{ old('height') }}">

                            @error('height')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Product Sample</label>
                            <div class="upload-image-wrapper d-flex align-items-center gap-3 w-100">
                                <div
                                    class="uploaded-img d-none position-relative h-120-px w-100 border input-form-light radius-8 overflow-hidden border-dashed bg-neutral-50">
                                    <button type="button"
                                        class="uploaded-img__remove position-absolute top-0 end-0 z-1 text-2xxl line-height-1 me-8 mt-8 d-flex">
                                        <iconify-icon icon="radix-icons:cross-2"
                                            class="text-xl text-danger-600"></iconify-icon>
                                    </button>
                                    <img class="uploaded-img__preview w-100 h-100 object-fit-cover" src=""
                                        alt="image">
                                </div>

                                <label
                                    class="upload-file h-120-px w-100 border input-form-light radius-8 overflow-hidden border-dashed bg-neutral-50 bg-hover-neutral-200 d-flex align-items-center flex-column justify-content-center gap-1">
                                    <iconify-icon icon="solar:camera-outline"
                                        class="text-xl text-secondary-light"></iconify-icon>
                                    <span class="fw-semibold text-secondary-light">Upload Image</span>
                                    <input type="file" name="image_sample"
                                        class="upload-input @error('image_sample') is-invalid @enderror" hidden>
                                </label>
                            </div>
                            @error('image_sample')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <input type="hidden" name="is_draft" id="is_draft" value="false">
                        <input type="hidden" name="customer_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="order_id" value="{{ $product->id }}">

                        <!-- Buttons for submitting -->
                        <div class="col-12">
                            <div class="row text-center mt-3">
                                <div class="col-6">
                                    <button type="submit"
                                        class="btn btn-danger radius-8 d-flex justify-content-center align-items-center gap-2 w-100"
                                        onclick="setIsDraft(false)">
                                        <iconify-icon icon="icon-park-outline:buy"
                                            class="menu-icon text-lg"></iconify-icon>
                                        <span>Order Now</span>
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button type="submit"
                                        class="btn btn-dark radius-8 d-flex justify-content-center align-items-center gap-2 w-100"
                                        onclick="setIsDraft(true)">
                                        <iconify-icon icon="humbleicons:cart" class="menu-icon text-lg"></iconify-icon>
                                        <span>Add to Cart</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        function setIsDraft(isDraft) {
            // Set nilai hidden input `is_draft` berdasarkan parameter
            document.getElementById('is_draft').value = isDraft;

            // Optional: Tampilkan konfirmasi sebelum submit
            let confirmationMessage = isDraft ? 'Are you sure you want to add this to cart?' :
                'Are you sure you want to order now?';
            if (confirm(confirmationMessage)) {
                document.getElementById('orderForm').submit(); // Only submit if confirmed
            } else {
                return false; // Prevent form submission if canceled
            }
        }
    </script>


    <script
        src="
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ">
    </script>
    <link href="
https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css
" rel="stylesheet">

    <script>
        var splide = new Splide('.splide', {
            type: 'loop',
            perPage: 3,
            focus: 'center',
        });

        splide.mount();
    </script>
@endsection
