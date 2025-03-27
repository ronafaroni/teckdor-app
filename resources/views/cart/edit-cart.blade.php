@extends('template.customer')

@section('customer-content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Edit Product</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="fluent-mdl2:product" class="icon text-lg"></iconify-icon>
                    Product
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Edit Product</li>
        </ul>
    </div>

    <div class="row gy-4">
        <div class="col-lg-12">
            <div class="card">
                {{-- <div class="card-header">
                <h5 class="card-title mb-0">Input Custom Styles</h5>
            </div> --}}
                <div class="card-body">
                    <form id="orderForm" action="{{ route('save-cart', ['id' => $order->id]) }}" method="POST"
                        class="row gy-3 needs-validation" enctype="multipart/form-data" novalidate>
                        @csrf

                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <input type="hidden" name="product_id" value="{{ $order->id }}">

                        <div class="col-12 p-24">
                            <label class="form-label fw-bold mb-3">Product Sample</label>
                            <div class="upload-image-wrapper d-flex flex-column align-items-center gap-4 w-100">
                                <!-- Container untuk gambar yang sudah ada -->
                                <div
                                    class="uploaded-img position-relative h-120-px w-100 border input-form-light radius-8 overflow-hidden border-dashed bg-neutral-50 {{ $order->img_sample ? '' : 'd-none' }}">
                                    <button type="button"
                                        class="uploaded-img__remove position-absolute top-0 end-0 z-1 text-2xxl line-height-1 me-8 mt-8 d-flex">
                                        <iconify-icon icon="radix-icons:cross-2"
                                            class="text-xl text-danger-600"></iconify-icon>
                                    </button>
                                    <img id="uploaded-img__preview"
                                        class="uploaded-img__preview w-100 h-100 object-fit-cover"
                                        src="{{ $order->img_sample ? asset('storage/' . $order->img_sample) : 'assets/images/user.png' }}"
                                        alt="Product Thumbnail">
                                </div>

                                <!-- Label untuk drag-and-drop atau upload gambar baru -->
                                <label
                                    class="upload-file h-120-px w-100 border input-form-light radius-8 overflow-hidden border-dashed bg-neutral-50 bg-hover-neutral-200 d-flex align-items-center flex-column justify-content-center gap-1">
                                    <iconify-icon icon="solar:camera-outline"
                                        class="text-xl text-secondary-light"></iconify-icon>
                                    <span class="fw-semibold text-secondary-light">Drag & Drop or Click to Upload</span>
                                    <input type="file" name="image_sample"
                                        class="upload-input @error('image_sample') is-invalid @enderror" hidden>
                                </label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <!-- Nama Produk & Stok di Kiri -->
                            <div class="d-flex flex-column">
                                <h4 class="mb-0">{{ $order->product->name_product }}</h4>
                                <span class="mb-0">Stock : {{ $order->product->stock }}</span>
                            </div>

                            <!-- Harga di Kanan -->
                            {{-- <h5 class="text-danger mb-0">{{ 'Rp. ' . number_format($product->price) ?? 'Rp. 0' }}</h5> --}}
                        </div>

                        <div class="col-md-12">
                            <hr>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Description</label>
                            <p class="text-justify">{{ $order->product->description }}</p>
                        </div>

                        <div class="col-md-12">
                            <hr>
                        </div>

                        <div class="col-md-3">
                            <span>Length : {{ number_format($order->product->length) }} Cm</span>
                        </div>
                        <div class="col-md-3">
                            <span>Width : {{ number_format($order->product->width) }} Cm</span>
                        </div>
                        <div class="col-md-3">
                            <span>Height : {{ number_format($order->product->height) }} Cm</span>
                        </div>
                        <div class="col-md-3">
                            <span>Weight : {{ number_format($order->product->weight) }} Kg</span>
                        </div>

                        <div class="col-md-12">
                            <hr>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Quantity</label>
                            <input type="number" name="qty" class="form-control @error('qty') is-invalid @enderror"
                                min="0" placeholder="Enter Quantity" value="{{ $order->qty }}">

                            @error('qty')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Order Description</label>
                            <textarea rows="5" type="text" name="desc_order" class="form-control @error('desc_order') is-invalid @enderror"
                                placeholder="Enter Order Description">{{ old('desc_order') ?? $order->description }}</textarea>
                            </textarea>
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

                        <input type="hidden" name="is_draft" id="is_draft" value="false">
                        <input type="hidden" name="customer_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="order_id" value="{{ $order->id }}">

                        <!-- Buttons for submitting -->
                        <div class="col-12">
                            <div class="row text-center mt-3">

                                <div class="col-3">
                                    <button type="submit"
                                        class="btn btn-dark radius-8 d-flex justify-content-center align-items-center gap-2 w-100"
                                        onclick="setIsDraft(true)">
                                        <iconify-icon icon="humbleicons:cart" class="menu-icon text-lg"></iconify-icon>
                                        <span>Save to Cart</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
