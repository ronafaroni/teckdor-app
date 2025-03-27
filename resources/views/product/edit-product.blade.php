@extends('template.admin')

@section('admin-content')
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
                    <form action="{{ route('update-product') }}" method="POST" class="row gy-3 needs-validation"
                        enctype="multipart/form-data" novalidate>
                        @csrf
                        @method('PUT')
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="card-body p-24">
                            <label class="form-label fw-bold mb-3">Upload Product Thumbnail</label>
                            <div class="upload-image-wrapper d-flex flex-column align-items-center gap-4 w-100">
                                <!-- Container untuk gambar yang sudah ada -->
                                <div
                                    class="uploaded-img position-relative h-120-px w-100 border input-form-light radius-8 overflow-hidden border-dashed bg-neutral-50 {{ $product->thumbnail ? '' : 'd-none' }}">
                                    <button type="button"
                                        class="uploaded-img__remove position-absolute top-0 end-0 z-1 text-2xxl line-height-1 me-8 mt-8 d-flex">
                                        <iconify-icon icon="radix-icons:cross-2"
                                            class="text-xl text-danger-600"></iconify-icon>
                                    </button>
                                    <img id="uploaded-img__preview"
                                        class="uploaded-img__preview w-100 h-100 object-fit-cover"
                                        src="{{ $product->thumbnail ? asset('storage/' . $product->thumbnail) : 'assets/images/user.png' }}"
                                        alt="Product Thumbnail">
                                </div>

                                <!-- Label untuk drag-and-drop atau upload gambar baru -->
                                <label id="drop-area"
                                    class="upload-file h-80-px w-100 d-flex align-items-center justify-content-center border input-form-light radius-8 overflow-hidden border-dashed bg-neutral-50 bg-hover-neutral-200">
                                    <iconify-icon icon="solar:camera-outline"
                                        class="text-xl text-secondary-light me-2"></iconify-icon>
                                    <span class="fw-semibold text-secondary-light">Drag & Drop or Click to Upload</span>
                                    <input id="upload-file" name="thumbnail" type="file" hidden>
                                </label>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Name Product</label>
                            <input type="text" name="product_name"
                                class="form-control @error('product_name') is-invalid @enderror"
                                placeholder="Enter Product Name" value="{{ old('product_name', $product->name_product) }}">

                            @error('product_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Description</label>
                            <textarea type="text" name="description" class="form-control @error('description') is-invalid @enderror"
                                placeholder="Enter Product Description" value="{{ old('description') }}">{{ old('description', $product->description) }}</textarea>

                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Category</label>
                            <select name="category_name" class="form-select @error('category_name') is-invalid @enderror">
                                <option value="{{ $product->category->id }}" selected>
                                    {{ $product->category->name_category }}</option>
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
                                <option value="{{ $product->supplier->id }}" selected>
                                    {{ $product->supplier->name_supplier }}</option>
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
                                placeholder="Enter Price"
                                value="{{ old('price', rtrim(rtrim($product->price, '0'), '.')) }}">

                            @error('price')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Stock</label>
                            <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror"
                                placeholder="Enter Stock" value="{{ old('stock', $product->stock) }}">

                            @error('stock')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Length (Cm)</label>
                            <input type="number" name="length" class="form-control @error('length') is-invalid @enderror"
                                placeholder="Enter Length" value="{{ old('length', number_format($product->length)) }}">

                            @error('length')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Width (Cm)</label>
                            <input type="number" name="width" class="form-control @error('width') is-invalid @enderror"
                                placeholder="Enter Width" value="{{ old('width', number_format($product->width)) }}">

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
                                value="{{ old('height', number_format($product->height)) }}">

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
                                value="{{ old('weight', number_format($product->weight)) }}">

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
                                    <!-- Radio Button for Available -->
                                    <div class="form-check checked-danger d-flex align-items-center gap-2">
                                        <input class="form-check-input" type="radio" name="product_status"
                                            value="available" id="horizontal1"
                                            {{ $product->status === 'available' ? 'checked' : '' }}>
                                        <label class="form-check-label line-height-1 fw-medium text-secondary-light"
                                            for="horizontal1">
                                            Available
                                        </label>
                                    </div>

                                    <!-- Radio Button for Unavailable -->
                                    <div class="form-check checked-danger d-flex align-items-center gap-2">
                                        <input class="form-check-input" type="radio" name="product_status"
                                            value="unavailable" id="horizontal2"
                                            {{ $product->status === 'unavailable' ? 'checked' : '' }}>
                                        <label class="form-check-label line-height-1 fw-medium text-secondary-light"
                                            for="horizontal2">
                                            Unavailable
                                        </label>
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
                                    <label class="form-label fw-bold mb-3">Product Images</label>

                                    <!-- Container untuk menampung semua form upload -->
                                    <div id="products-container" class="d-flex flex-column gap-4">
                                        @foreach ($product->images as $productImage)
                                            <div class="product-item">
                                                <div id="upload-container-{{ $productImage->id }}"
                                                    class="d-flex flex-column gap-3">
                                                    <!-- Form Upload -->
                                                    <div class="upload-item">
                                                        <div
                                                            class="upload-image-wrapper d-flex align-items-center gap-3 w-100">
                                                            <!-- Gambar yang diunggah -->
                                                            <div
                                                                class="col-md-11 uploaded-img position-relative h-120-px w-100 border input-form-light radius-8 overflow-hidden border-dashed bg-neutral-50">
                                                                <button type="button"
                                                                    class="remove-upload position-absolute top-0 end-0 z-1 text-2xxl line-height-1 me-8 mt-8 d-flex"
                                                                    data-image-id="{{ $productImage->id }}">
                                                                    <iconify-icon icon="radix-icons:cross-2"
                                                                        class="text-xl text-danger-600"></iconify-icon>
                                                                </button>
                                                                {{-- <img class="uploaded-img__preview w-100 h-100 object-fit-cover"
                                                                    src="{{ $productImage->img_product ? asset('storage/' . $productImage->img_product) : '' }}"
                                                                    alt="Product Image"> --}}
                                                                <img class="uploaded-img__preview w-100 h-100 object-fit-cover"
                                                                    src="{{ $productImage->img_product ? asset('storage/' . $productImage->img_product) : '' }}"
                                                                    alt="Product Image">
                                                            </div>

                                                            <!-- Label untuk upload gambar -->
                                                            <label
                                                                class="upload-file h-120-px w-100 border input-form-light radius-8 overflow-hidden border-dashed bg-neutral-50 bg-hover-neutral-200 d-flex align-items-center flex-column justify-content-center gap-1 drag-drop-area">
                                                                <iconify-icon icon="solar:camera-outline"
                                                                    class="text-xl text-secondary-light"></iconify-icon>
                                                                <span class="fw-semibold text-secondary-light">Upload or
                                                                    Drag Image Here</span>
                                                                <input type="file" name="images_product[]" multiple
                                                                    hidden>
                                                            </label>

                                                            <!-- Tombol untuk menghapus gambar -->
                                                            {{-- <div class="col-md-1 mt-2">
                                                                <button type="button"
                                                                    class="btn btn-danger radius-8 text-center remove-upload"
                                                                    data-image-id="{{ $productImage->id }}">
                                                                    <iconify-icon icon="material-symbols:delete-rounded"
                                                                        class="text-xl"></iconify-icon>
                                                                </button>

                                                            </div> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Tombol Tambah Gambar -->
                                    <div class="col-md-12 mt-3">
                                        <button type="button" id="add-upload"
                                            class="btn btn-dark radius-8 text-center w-100 d-flex justify-content-center align-items-center gap-2">
                                            <iconify-icon icon="ph:plus-fill" class="menu-icon text-lg"></iconify-icon>
                                            <span>Add Another Image</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-danger-600 radius-8 d-flex align-items-center gap-2"
                                onclick="return confirm('Are you want to update this product?')">
                                <iconify-icon icon="ix:product-management" class="menu-icon text-lg"></iconify-icon>
                                <span>Update Product</span>
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
                    class="col-md-11 uploaded-img d-none position-relative h-120-px w-100 border input-form-light radius-8 overflow-hidden border-dashed bg-neutral-50">
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

    {{-- Untuk upload Thumbnail --}}
    <script>
        const fileInput = document.getElementById("upload-file");
        const dropArea = document.getElementById("drop-area");
        const imagePreview = document.getElementById("uploaded-img__preview");
        const uploadedImgContainer = document.querySelector(".uploaded-img");
        const removeButton = document.querySelector(".uploaded-img__remove");

        // Fungsi untuk menampilkan preview gambar
        function previewImage(file) {
            const src = URL.createObjectURL(file);
            imagePreview.src = src;
            uploadedImgContainer.classList.remove('d-none');
        }

        // Event untuk file input
        fileInput.addEventListener("change", (e) => {
            if (e.target.files.length) {
                previewImage(e.target.files[0]);
            }
        });

        // Event drag & drop
        dropArea.addEventListener("dragover", (e) => {
            e.preventDefault();
            dropArea.classList.add("bg-hover-neutral-200");
        });

        dropArea.addEventListener("dragleave", () => {
            dropArea.classList.remove("bg-hover-neutral-200");
        });

        dropArea.addEventListener("drop", (e) => {
            e.preventDefault();
            dropArea.classList.remove("bg-hover-neutral-200");
            const files = e.dataTransfer.files;
            if (files.length) {
                fileInput.files = files; // Assign files to input
                previewImage(files[0]);
            }
        });

        // Tombol untuk menghapus gambar
        removeButton.addEventListener("click", () => {
            imagePreview.src =
                "{{ $product->thumbnail ? asset('storage/' . $product->thumbnail) : 'assets/images/user.png' }}";
            uploadedImgContainer.classList.add('d-none');
            fileInput.value = ""; // Reset input file
        });
    </script>

    {{-- Untuk Multiple Download --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const productsContainer = document.getElementById("products-container");
            const addUploadButton = document.getElementById("add-upload");

            // Fungsi untuk membuat form upload kosong
            function createEmptyForm() {
                const formHTML = `
            <div class="product-item">
                <div class="d-flex flex-column gap-3">
                    <div class="upload-item">
                        <div class="upload-image-wrapper d-flex align-items-center gap-3 w-100">
                            <!-- Container Gambar Kosong -->
                            <div class="col-md-11 uploaded-img position-relative h-120-px w-100 border input-form-light radius-8 overflow-hidden border-dashed bg-neutral-50 d-none">
                                <button type="button" class="uploaded-img__remove position-absolute top-0 end-0 z-1 text-2xxl line-height-1 me-8 mt-8 d-flex">
                                    <iconify-icon icon="radix-icons:cross-2" class="text-xl text-danger-600"></iconify-icon>
                                </button>
                                <img class="uploaded-img__preview w-100 h-100 object-fit-cover" src="" alt="Product Image">
                            </div>
                            <!-- Label untuk upload gambar -->
                            <label class="upload-file h-120-px w-100 border input-form-light radius-8 overflow-hidden border-dashed bg-neutral-50 bg-hover-neutral-200 d-flex align-items-center flex-column justify-content-center gap-1 drag-drop-area">
                                <iconify-icon icon="solar:camera-outline" class="text-xl text-secondary-light"></iconify-icon>
                                <span class="fw-semibold text-secondary-light">Upload or Drag Image Here</span>
                                <input type="file" name="images_product[]" multiple hidden>
                            </label>
                            <!-- Tombol Hapus -->
                            <div class="col-md-1 mt-2">
                                <button type="button" class="btn btn-danger radius-8 text-center remove-upload">
                                    <iconify-icon icon="material-symbols:delete-rounded" class="text-xl"></iconify-icon>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
                return formHTML;
            }

            // Tambah form upload baru
            addUploadButton.addEventListener("click", function() {
                const newForm = document.createElement("div");
                newForm.innerHTML = createEmptyForm();
                productsContainer.appendChild(newForm);
                initializeDragAndDrop(newForm.querySelector(".drag-drop-area"));
                attachRemoveHandler(newForm.querySelector(".remove-upload"));
            });

            // Hapus form upload
            function attachRemoveHandler(button) {
                button.addEventListener("click", function() {
                    button.closest(".product-item").remove();
                });
            }

            // Tambahkan handler ke tombol yang ada
            document.querySelectorAll(".remove-upload").forEach(attachRemoveHandler);

            // Fungsi Drag & Drop
            function initializeDragAndDrop(area) {
                const input = area.querySelector("input");
                const previewContainer = area.closest(".upload-image-wrapper").querySelector(".uploaded-img");
                const previewImage = previewContainer.querySelector(".uploaded-img__preview");

                area.addEventListener("dragover", (e) => {
                    e.preventDefault();
                    area.classList.add("bg-hover-neutral-200");
                });

                area.addEventListener("dragleave", () => {
                    area.classList.remove("bg-hover-neutral-200");
                });

                area.addEventListener("drop", (e) => {
                    e.preventDefault();
                    area.classList.remove("bg-hover-neutral-200");

                    const files = e.dataTransfer.files;
                    if (files.length > 0) {
                        input.files = files;
                        showPreview(files[0], previewContainer, previewImage);
                    }
                });

                input.addEventListener("change", () => {
                    if (input.files.length > 0) {
                        showPreview(input.files[0], previewContainer, previewImage);
                    }
                });
            }

            // Tampilkan Preview Gambar
            function showPreview(file, previewContainer, previewImage) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewContainer.classList.remove("d-none");
                };
                reader.readAsDataURL(file);
            }

            // Inisialisasi Drag & Drop untuk form yang sudah ada
            document.querySelectorAll(".drag-drop-area").forEach(initializeDragAndDrop);
        });
    </script>

    {{-- Untuk proses delete images --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Menangani klik pada tombol hapus
            document.querySelectorAll(".remove-upload").forEach(button => {
                button.addEventListener("click", function() {
                    const imageId = this.getAttribute("data-image-id");

                    // Kirim request untuk menghapus gambar
                    if (confirm("Are you sure you want to delete this image?")) {
                        fetch(`/product/delete-image/${imageId}`, {
                                method: "DELETE",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({
                                    image_id: imageId
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Hapus elemen gambar dari tampilan
                                    const imageElement = this.closest(".product-item");
                                    imageElement.remove();
                                } else {
                                    alert("Failed to delete image.");
                                }
                            })
                            .catch(error => {
                                console.error("Error:", error);
                                alert("An error occurred while deleting the image.");
                            });
                    }
                });
            });
        });
    </script>
@endsection
