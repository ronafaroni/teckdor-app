@extends('template.admin')

@section('admin-content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">History Product</h6>
        <ul class="d-flex align-items-center gap-2">

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
                <table class="table bordered-table mb-0" id="dataTable" data-page-length='10'>
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Date</th>
                            <th scope="col">Code Product</th>
                            <th scope="col">Name Product</th>
                            <th scope="col">Stock Update</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody align="center">
                        @foreach ($stocks as $data)
                            <tr>
                                <td>
                                    <div class="form-check style-check d-flex align-items-center">
                                        <label class="form-check-label">
                                            {{ $loop->iteration }}
                                        </label>
                                    </div>
                                </td>
                                <td>{{ $data->created_at->format('d F Y H:i:s') }}</td>
                                <td>{{ $data->product_code }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('storage/' . $data->product->thumbnail) }}" alt=""
                                            class="flex-shrink-0 me-12 radius-8"
                                            style="width: 40px; height: 40px; object-fit: cover; border-radius: 8px;">
                                        <h6 class="text-md mb-0 fw-medium flex-grow-1">{{ $data->product->name_product }}
                                        </h6>
                                    </div>
                                </td>
                                <td>{{ $data->stock }} Set</td>
                                <td>
                                    <a data-bs-toggle="modal" data-bs-target="#updateStockModal{{ $data->id }}"
                                        class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                        <iconify-icon icon="lucide:edit"></iconify-icon>
                                    </a>
                                    <a href="{{ route('delete-history-stock', ['id' => $data['id']]) }}"
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

    @foreach ($stocks as $item)
        <!-- Modal Tambah Stock -->
        <div class="modal fade" id="updateStockModal{{ $item->id }}" tabindex="-1"
            aria-labelledby="updateStockModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateSupplierModalLabel">Update Stock</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="updateSupplierForm" method="POST"
                        action="{{ route('update-history-stock', ['id' => $item->id]) }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $item->id }}">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="code_product" class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="name_product" name="name_product"
                                    autocomplete="off"
                                    value="{{ $item->product->code_product }} - {{ $item->product->name_product }}"
                                    readonly></input>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Stock</label>
                                <input type="number" class="form-control" id="stock" name="stock"
                                    autocomplete="off" value="{{ $item->stock }}"></input>
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
                <form id="updateSupplierForm" method="POST" action="{{ route('update-stock1') }}">
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
@endsection
