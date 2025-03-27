@extends('template.admin')

@section('admin-content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Add New Product</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="fluent-mdl2:product" class="icon text-lg"></iconify-icon>
                    Product
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Add Product</li>
        </ul>
    </div>

    <div class="row gy-4">
        <div class="col-lg-12">
            <div class="card">
                {{-- <div class="card-header">
                    <h5 class="card-title mb-0">Input Custom Styles</h5>
                </div> --}}
                <div class="card-body">
                    <form action="{{ route('save-product') }}" method="POST" class="row gy-3 needs-validation"
                        enctype="multipart/form-data" novalidate>
                        @csrf

                        <div class="col-md-12">
                            <label class="form-label">Upload Product Thumbnail</label>
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
                                    <input type="file" name="thumbnail"
                                        class="upload-input @error('thumbnail') is-invalid @enderror" hidden>
                                </label>
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
                                placeholder="Enter Product Name" value="{{ old('product_name') }}">

                            @error('product_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Description</label>
                            <textarea type="text" name="description" class="form-control @error('description') is-invalid @enderror"
                                placeholder="Enter Product Description" value="{{ old('description') }}">{{ old('description') }}</textarea>

                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Category</label>
                            <select name="category_name" class="form-select @error('category_name') is-invalid @enderror">
                                <option value="" disabled selected>Select Category</option>
                                @foreach ($category as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('category_name') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name_category }}
                                    </option>
                                @endforeach
                            </select>

                            @error('category_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Supplier</label>
                            <select name="supplier_name" class="form-select @error('supplier_name') is-invalid @enderror">
                                <option value="" disabled selected>Select Supplier</option>
                                @foreach ($supplier as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('supplier_name') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name_supplier }}
                                    </option>
                                @endforeach
                            </select>

                            @error('supplier_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Price</label>
                            <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                                placeholder="Enter Price" value="{{ old('price') }}">

                            @error('price')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Stock</label>
                            <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror"
                                placeholder="Enter Stock" value="{{ old('stock') }}">

                            @error('stock')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Length (Cm)</label>
                            <input type="number" name="length" class="form-control @error('length') is-invalid @enderror"
                                placeholder="Enter Length" value="{{ old('length') }}">

                            @error('length')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Width (Cm)</label>
                            <input type="number" name="width" class="form-control @error('width') is-invalid @enderror"
                                placeholder="Enter Width" value="{{ old('width') }}">

                            @error('width')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Height (Cm)</label>
                            <input type="number" name="height"
                                class="form-control @error('height') is-invalid @enderror" placeholder="Enter Height"
                                value="{{ old('height') }}">

                            @error('height')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Weight (Kg)</label>
                            <input type="number" name="weight"
                                class="form-control @error('weight') is-invalid @enderror" placeholder="Enter Weight"
                                value="{{ old('weight') }}">

                            @error('weight')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <div class="icon-field has-validation">
                                <label class="form-label">Product Status</label>
                                <div class="d-flex align-items-center flex-wrap gap-28">
                                    <div class="form-check checked-danger d-flex align-items-center gap-2">
                                        <input class="form-check-input" type="radio" name="product_status"
                                            value="available" id="horizontal1" checked>
                                        <label class="form-check-label line-height-1 fw-medium text-secondary-light"
                                            for="horizontal1"> Available </label>
                                    </div>
                                    <div class="form-check checked-danger d-flex align-items-center gap-2">
                                        <input class="form-check-input" type="radio" name="product_status"
                                            value="unavailable" id="horizontal2">
                                        <label class="form-check-label line-height-1 fw-medium text-secondary-light"
                                            for="horizontal2"> unavailable </label>
                                    </div>
                                </div>

                                @error('product_status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>
                        </div>

                        <div class="col-md-12">
                            <hr>
                        </div>

                        {{-- Untuk Menambahkan gambar product --}}
                        <div class="col-md-12">

                            <div class="card">
                                <div class="card-body">
                                    <label class="form-label">Upload Product Image</label>

                                    <div id="upload-container" class="d-flex flex-column gap-3">
                                        <!-- Form upload pertama -->
                                        <div class="upload-item">
                                            <div class="upload-image-wrapper d-flex align-items-center gap-3 w-100">
                                                <!-- Container untuk gambar yang diunggah -->
                                                <div
                                                    class="col-md-11 uploaded-img d-none position-relative h-120-px w-80 border input-form-light radius-8 overflow-hidden border-dashed bg-neutral-50">
                                                    <button type="button"
                                                        class="uploaded-img__remove position-absolute top-0 end-0 z-1 text-2xxl line-height-1 me-8 mt-8 d-flex">
                                                        <iconify-icon icon="radix-icons:cross-2"
                                                            class="text-xl text-danger-600"></iconify-icon>
                                                    </button>
                                                    <img class="uploaded-img__preview w-100 h-100 object-fit-cover"
                                                        src="" alt="image">
                                                </div>
                                                <!-- Label untuk memilih gambar -->
                                                <label
                                                    class="upload-file h-120-px w-100 border input-form-light radius-8 overflow-hidden border-dashed bg-neutral-50 bg-hover-neutral-200 d-flex align-items-center flex-column justify-content-center gap-1">
                                                    <iconify-icon icon="solar:camera-outline"
                                                        class="text-xl text-secondary-light"></iconify-icon>
                                                    <span class="fw-semibold text-secondary-light">Upload
                                                        Image</span>
                                                    <input type="file" name="images_product[]"
                                                        class="upload-input @error('images_product.*') is-invalid @enderror"
                                                        multiple hidden>
                                                </label>

                                                @error('images_product.*')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror

                                                <!-- Tombol Delete Another Upload -->
                                                <div class="col-md-1 mt-2">
                                                    <button type="button"
                                                        class="btn btn-danger radius-8 text-center d-flex justify-content-center align-items-center gap-2 remove-upload">
                                                        <iconify-icon icon="material-symbols:delete-rounded"
                                                            class="text-xl"></iconify-icon>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Tombol Add Another Upload -->
                                        <div class="col-md-12 mt-3">
                                            <button type="button" id="add-upload"
                                                class="btn btn-dark-600 radius-8 text-center w-100 d-flex justify-content-center align-items-center gap-2">
                                                <iconify-icon icon="ph:plus-fill"
                                                    class="menu-icon text-lg"></iconify-icon>
                                                <span>Add Another Product</span>
                                            </button>
                                        </div>

                                    </div>

                                </div>
                            </div>

                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-danger radius-8 d-flex align-items-center gap-2"
                                onclick="return confirm('Are you want to save?')">
                                <iconify-icon icon="ix:product-management" class="menu-icon text-lg"></iconify-icon>
                                <span>Save Product</span>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const addButton = document.getElementById('add-upload');
            const uploadContainer = document.getElementById('upload-container');

            addButton.addEventListener('click', function() {
                const newUploadItem = document.createElement('div');
                newUploadItem.classList.add('upload-item');
                newUploadItem.innerHTML = `
            <div class="upload-image-wrapper d-flex align-items-center gap-3 w-100">
                <div
                    class="col-md-11 uploaded-img d-none position-relative h-120-px w-80 border input-form-light radius-8 overflow-hidden border-dashed bg-neutral-50">
                    <button type="button"
                        class="uploaded-img__remove position-absolute top-0 end-0 z-1 text-2xxl line-height-1 me-8 mt-8 d-flex">
                        <iconify-icon icon="radix-icons:cross-2"
                            class="text-xl text-danger-600"></iconify-icon>
                    </button>
                    <img class="uploaded-img__preview w-100 h-100 object-fit-cover"
                        src="" alt="image">
                </div>
                
                <!-- Label untuk memilih gambar -->
                <label
                    class="upload-file h-120-px w-100 border input-form-light radius-8 overflow-hidden border-dashed bg-neutral-50 bg-hover-neutral-200 d-flex align-items-center flex-column justify-content-center gap-1">
                    <iconify-icon icon="solar:camera-outline"
                        class="text-xl text-secondary-light"></iconify-icon>
                    <span class="fw-semibold text-secondary-light">Upload
                        Image</span>
                    <input type="file" name="images_product[]"
                        class="upload-input @error('images_product.*') is-invalid @enderror"
                        multiple hidden>
                </label>

            <!-- Tombol Delete Another Upload -->
                <div class="col-md-1 mt-2">
                    <button type="button"
                        class="btn btn-danger radius-8 text-center d-flex justify-content-center align-items-center gap-2 remove-upload">
                        <iconify-icon icon="material-symbols:delete-rounded"
                            class="text-xl"></iconify-icon>
                    </button>
                </div>
            </div>
        `;

                // Sisipkan elemen baru sebelum tombol "Add Another Product"
                uploadContainer.insertBefore(newUploadItem, addButton.parentElement);
            });

            // Delegasi event untuk tombol hapus gambar
            uploadContainer.addEventListener('click', function(e) {
                if (e.target.closest(".remove-upload")) {
                    e.target.closest('.upload-item').remove();
                }
            });
        });
    </script>
@endsection
