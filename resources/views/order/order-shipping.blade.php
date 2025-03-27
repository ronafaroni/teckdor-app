@extends('template.admin')

@section('admin-content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Order Shipping</h6>
        <ul class="d-flex align-items-center gap-2">
            {{-- <li class="fw-medium">
                <button type="button" class="btn btn-outline-success-600 radius-8 px-20 py-11">Add Users</button>
            </li> --}}
            <li>
                <button data-bs-toggle="modal" data-bs-target="#addShipping"
                    class="btn btn-danger radius-8 d-flex align-items-center gap-2">
                    <iconify-icon icon="akar-icons:shipping-box-02" class="menu-icon text-lg"></iconify-icon>
                    <span>Add Shipping</span>
                </button>

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
                            <th scope="col">Code Shipping</th>
                            <th scope="col">Product</th>
                            <th scope="col">Date</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody align="center">
                        @foreach ($order_shipping_list as $shipping)
                            <tr>
                                <td>
                                    <div class="form-check style-check d-flex align-items-center">
                                        <label class="form-check-label">
                                            {{ $loop->iteration }}
                                        </label>
                                    </div>
                                </td>
                                <td>{{ $shipping->code_shipping }}</td>
                                <td>{{ $shipping->total_products }} X Order Product</td>
                                <td>{{ $shipping->created_at->format('d F Y H:i:s') }}</td>
                                <td>
                                    <a href="{{ route('order-shipping-detail', $shipping->code_shipping) }}"
                                        class="btn btn-sm btn-dark radius-8 d-flex align-items-center justify-content-center gap-2 delete-shipping""
                                        style="padding: 8px 16px; font-size: 14px;" data-id="{{ $shipping->id }}">
                                        <iconify-icon icon="hugeicons:shipping-loading"
                                            class="menu-icon text-lg"></iconify-icon>
                                        <span>Detail Shipping</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <div class="modal fade" id="addShipping" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Shipping</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('order-shipping-update') }}">
                    @csrf
                    <div class="modal-body">
                        <label class="form-label">Order List</label>
                        <select class="form-select" id="order-select" name="order_id" required>
                            <option value="" disabled selected>Order Select</option>
                            @foreach ($order_progress_list as $item)
                                @if ($item->order && $item->order->product)
                                    <option value="{{ $item->order_id }}" data-code="{{ $item->order->code_order }}"
                                        data-product="{{ $item->order->product->name_product }}">
                                        {{ $item->order->code_order }} - {{ $item->order->product->name_product }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <!-- Daftar Produk yang Ditambahkan -->
                    <div class="modal-body">
                        <label class="form-label">Selected Products</label>
                        <div id="product-list">
                            <!-- Produk yang dipilih akan muncul di sini -->
                        </div>
                    </div>

                    <!-- Hidden input untuk menyimpan produk yang dipilih -->
                    <input type="hidden" name="code_shipping" id="code-shipping">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Add Shipping</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const orderSelect = document.getElementById("order-select");
            const productList = document.getElementById("product-list");
            const codeShippingInput = document.getElementById("code-shipping");

            // Saat memilih produk dari dropdown
            orderSelect.addEventListener("change", function() {
                let selectedOption = orderSelect.options[orderSelect.selectedIndex];
                let codeOrder = selectedOption.dataset.code;
                let productName = selectedOption.dataset.product;
                let orderId = selectedOption.value;

                // Set nilai code_shipping (gunakan code_order sebagai kode pengiriman jika masih kosong)
                if (!codeShippingInput.value) {
                    codeShippingInput.value = codeOrder;
                }

                // Tambahkan produk ke daftar (jika belum ada)
                let existingProduct = document.querySelector(`input[value="${orderId}"]`);
                if (!existingProduct) {
                    let productHtml = `
                    <div class="input-group mb-2 product-item">
                        <span class="input-group-text">${codeOrder}</span>
                        <input type="text" class="form-control" value="${productName}" readonly>
                        <input type="hidden" name="products[]" value="${orderId}">
                        <button type="button" class="btn btn-danger remove-product">×</button>
                    </div>`;
                    productList.insertAdjacentHTML("beforeend", productHtml);
                }
            });

            // Hapus produk dari daftar
            productList.addEventListener("click", function(e) {
                if (e.target.classList.contains("remove-product")) {
                    e.target.closest(".product-item").remove();
                }
            });
        });
    </script>
@endsection
