@extends('template.admin')

@section('admin-content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Products</h6>
        <ul class="d-flex align-items-center gap-2">
            {{-- <li class="fw-medium">
                <button type="button" class="btn btn-outline-success-600 radius-8 px-20 py-11">Add Users</button>
            </li> --}}
            <li>
                <a href="{{ route('add-product') }}" class="btn btn-dark radius-8 d-flex align-items-center gap-2">
                    <iconify-icon icon="fluent-mdl2:product-release" class="menu-icon text-lg"></iconify-icon>
                    <span>Add Product</span>
                </a>
            </li>
            <li>
                <a class="btn btn-danger radius-8 d-flex align-items-center gap-2" data-bs-toggle="modal"
                    data-bs-target="#updateStockModal">
                    <iconify-icon icon="fluent-mdl2:product-release" class="menu-icon text-lg"></iconify-icon>
                    <span>Add Stock</span>
                </a>
            </li>

        </ul>
    </div>

    <div class="card basic-data-table">
        <div class="card-body">

            @if (session()->has('success'))
                <div class="mb-16">
                    <div class="alert alert-success bg-success-100 text-success-600 border-success-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-0 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between"
                        role="alert">
                        <div class="d-flex align-items-center gap-2">
                            <iconify-icon icon="akar-icons:double-check" class="icon text-xl"></iconify-icon>
                            <span>{{ session()->get('success') }}</span>
                        </div>
                        <button class="remove-button text-success-600 text-xxl line-height-1"> <iconify-icon
                                icon="iconamoon:sign-times-light" class="icon"></iconify-icon></button>
                    </div>
                </div>
            @endif

            @if (session()->has('updated'))
                <div class="mb-16">
                    <div class="alert alert-warning bg-warning-100 text-warning-600 border-warning-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-0 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between"
                        role="alert">
                        <div class="d-flex align-items-center gap-2">
                            <iconify-icon icon="mdi:alert-circle-outline" class="icon text-xl"></iconify-icon>
                            <span>{{ session()->get('updated') }}</span>
                        </div>
                        <button class="remove-button text-warning-600 text-xxl line-height-1"> <iconify-icon
                                icon="iconamoon:sign-times-light" class="icon"></iconify-icon></button>
                    </div>
                </div>
            @endif

            @if (session()->has(key: 'deleted'))
                <div class="mb-16">
                    <div class="alert alert-danger bg-danger-100 text-danger-600 border-danger-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-0 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between"
                        role="alert">
                        <div class="d-flex align-items-center gap-2">
                            <iconify-icon icon="mingcute:delete-2-line" class="icon text-xl"></iconify-icon>
                            <span>{{ session()->get('deleted') }}</span>
                        </div>
                        <button class="remove-button text-danger-600 text-xxl line-height-1"> <iconify-icon
                                icon="iconamoon:sign-times-light" class="icon"></iconify-icon></button>
                    </div>
                </div>
            @endif

            <div class="table-responsive scroll-sm">
                <table class="table bordered-table mb-0" data-page-length='10'>
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Code</th>
                            <th scope="col">Product</th>
                            <th scope="col">Category</th>
                            <th scope="col">Price</th>
                            <th scope="col">Stocks</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody align="center">
                        @foreach ($data_product as $data)
                            <tr>
                                <td>
                                    <div class="form-check style-check d-flex align-items-center">
                                        <label class="form-check-label">
                                            {{ $loop->iteration }}
                                        </label>
                                    </div>
                                </td>
                                <td>{{ $data->code_product }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('storage/' . $data->thumbnail) }}" alt=""
                                            class="flex-shrink-0 me-12 radius-8"
                                            style="width: 40px; height: 40px; object-fit: cover; border-radius: 8px;">
                                        <h6 class="text-md mb-0 fw-medium flex-grow-1">{{ $data->name_product }}</h6>
                                    </div>
                                </td>
                                <td>{{ $data->category->name_category }}</td>
                                <td>{{ 'Rp. ' . number_format($data->price) ?? 'Rp. 0' }}</td>
                                <td>
                                    {{ ($data->product_stocks_sum_stock ?? 0) + ($data->stock ?? 0) + ($data->orders_sum_qty ?? 0) }}
                                    Set
                                </td>
                                <td>
                                    <a href="#"
                                        class="w-32-px h-32-px bg-warning-focus text-warning-main rounded-circle d-inline-flex align-items-center justify-content-center"
                                        data-bs-toggle="modal" data-bs-target="#productModal{{ $data->id }}">
                                        <iconify-icon icon="lsicon:view-outline"></iconify-icon>
                                    </a>

                                    <a href="{{ route('edit-product', ['id' => $data['id']]) }}"
                                        class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                        <iconify-icon icon="lucide:edit"></iconify-icon>
                                    </a>
                                    <a href="{{ route('delete-product', ['id' => $data['id']]) }}"
                                        class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center"
                                        onclick="return confirm('Are you sure want to delete?')">
                                        <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                    </a>
                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @foreach ($data_product as $product)
        <!-- Modal Detail Product -->
        <div class="modal fade" id="productModal{{ $product->id }}" tabindex="-1" aria-labelledby="productModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="productModalLabel">Product Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <form action="{{ route('save-product') }}" method="POST" class="row gy-3 needs-validation"
                                enctype="multipart/form-data" novalidate>
                                @csrf

                                <div class="col-md-12">
                                    <label class="form-label">Upload Product Thumbnail</label>
                                    <div class="upload-image-wrapper d-flex align-items-center gap-3 w-100">
                                        <div
                                            class="uploaded-img position-relative h-120-px w-100 border input-form-light radius-8 overflow-hidden border-dashed bg-neutral-50">

                                            <!-- Menampilkan gambar dari database -->
                                            <img class="uploaded-img__preview w-100 h-100 object-fit-cover"
                                                src="{{ asset('storage/' . $product->thumbnail) }}"
                                                alt="Product Thumbnail">
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
                                        placeholder="Enter Product Name" value="{{ $product->name_product }}" readonly>

                                    @error('product_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Description</label>
                                    <textarea rows="5" type="text" name="description"
                                        class="form-control @error('description') is-invalid @enderror" placeholder="Enter Product Description"
                                        value="{{ old('description') }}" readonly>{{ $product->description }}</textarea>

                                    @error('description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Category</label>
                                    <input type="text" class="form-control"
                                        value="{{ $product->category->name_category }}" readonly>

                                    @error('category_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Supplier</label>
                                    <input type="text" class="form-control"
                                        value="{{ $product->supplier->name_supplier }}" readonly>

                                    @error('supplier_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Price</label>
                                    <input type="text" name="price"
                                        class="form-control @error('price') is-invalid @enderror"
                                        placeholder="Enter Price"
                                        value="Rp. {{ number_format($product->price, 0, ',', '.') ?? 'Rp. 0' }}" readonly>

                                    @error('price')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Stock</label>
                                    <input type="number" name="stock"
                                        class="form-control @error('stock') is-invalid @enderror"
                                        placeholder="Enter Stock" value="{{ number_format($product->stock) }}" readonly>

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
                                        placeholder="Enter Length" value="{{ number_format($product->length) }}"
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
                                        placeholder="Enter Width" value="{{ number_format($product->width) }}" readonly>

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
                                        placeholder="Enter Height" value="{{ number_format($product->height) }}"
                                        readonly>

                                    @error('height')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Weight (Kg)</label>
                                    <input type="number" name="weight"
                                        class="form-control @error('weight') is-invalid @enderror"
                                        placeholder="Enter Weight" value="{{ number_format($product->weight) }}"
                                        readonly>

                                    @error('weight')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Product Status</label>
                                    <input type="text" name="status"
                                        class="form-control @error('status') is-invalid @enderror"
                                        placeholder="Enter Status" value="{{ $product->status }}" readonly>
                                </div>

                                <div class="col-md-12">
                                    <hr>
                                </div>

                                {{-- Untuk Menambahkan gambar product --}}
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <label class="form-label">Product Image</label>
                                            <div class="row">
                                                @foreach ($product->images as $productImg)
                                                    <div
                                                        class="col-md-3 col-sm-4 col-6 d-flex justify-content-center align-items-center mb-3">
                                                        <img src="{{ asset('storage/' . $productImg->img_product) }}"
                                                            class="img-fluid img-thumbnail" alt="..."
                                                            style="height: auto; object-fit: cover;">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Modal Tambah Stock -->
    <div class="modal fade" id="updateStockModal" tabindex="-1" aria-labelledby="updateStockModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateSupplierModalLabel">Update Stock</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="updateSupplierForm" method="POST" action="{{ route('update-stock') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="code_product" class="form-label">Product Name</label>
                            <select name="code_product" class="form-select @error('code_product') is-invalid @enderror">
                                <option value="" disabled selected>Select Product</option>
                                @foreach ($data_product as $product)
                                    <option value="{{ $product->code_product }}">{{ $product->code_product }} -
                                        {{ $product->name_product }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="stock" name="stock" autocomplete="off"
                                required></input>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Update Stock</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include Bootstrap JS (should be after jQuery) -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> --}}

    <!-- Your custom script -->
    <script>
        $(document).ready(function() {
            // Ketika tombol edit di modal update ditekan
            $('.edit-category').on('click', function() {
                var id = $(this).data('id');
                var name = $(this).data('name');

                // Set data ke modal
                $('#id_category').val(id);
                $('#name_category').val(name);

                // Tampilkan modal update
                $('#updateCategoryModal').modal('show');
            });

            // Reset form tambah saat modal update ditutup
            $('#updateCategoryModal').on('hidden.bs.modal', function() {
                // Mengosongkan form update setelah modal ditutup
                $('#updateCategoryForm')[0].reset();

                // Reset form tambah agar tidak terganggu
                $('#addCategoryForm')[0].reset(); // Tambahkan ini untuk reset form tambah
            });

            // Tambahkan event submit untuk form tambah, reset form setelah submit
            $('#addCategoryForm').on('submit', function() {
                // Reset form setelah submit (setelah data berhasil ditambahkan)
                $('#addCategoryForm')[0].reset();
            });
        });
    </script>
@endsection
