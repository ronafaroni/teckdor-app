@extends('template.admin')

@section('admin-content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Order Detail</h3>
        </div>

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

        <div class="card-body">

            <div class="row mt-4">
                <div class="col-md-3 d-flex flex-column">
                    <p class="text-sm text-muted mb-1">Code Shipping</p>
                    <span class="fw-medium">{{ $order_shipping->first()->code_shipping ?? 'N/A' }}</span>
                </div>

                <div class="col-md-3 d-flex flex-column">
                    <p class="text-sm text-muted mb-1">Date</p>
                    <span class="fw-medium">{{ $order_shipping->first()->created_at->format('d M Y h:i:s') ?? 'Unknown' }}
                </div>

                <div class="col-md-6 d-flex flex-column align-items-end">
                    <ul class="d-flex align-items-center gap-6 ms-auto">
                        <li>
                            <button data-bs-toggle="modal" data-bs-target="#addShipping"
                                class="btn btn-dark radius-8 d-flex align-items-center gap-2">
                                <iconify-icon icon="fluent-mdl2:product-release" class="menu-icon text-lg"></iconify-icon>
                                <span>Add Shipping</span>
                            </button>
                        </li>
                        <li>
                            <a href="{{ route('order-shipping-print', $order_shipping->first()->code_shipping) }}"
                                class="btn btn-danger radius-8 d-flex align-items-center gap-2" target="_blank">
                                <iconify-icon icon="ion:print-outline" class="menu-icon text-lg"></iconify-icon>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('order-shipping-export', $order_shipping->first()->code_shipping) }}"
                                class="btn btn-danger radius-8 d-flex align-items-center gap-2">
                                <iconify-icon icon="material-symbols:file-export" class="menu-icon text-lg"></iconify-icon>

                            </a>
                        </li>
                    </ul>
                </div>

            </div>
            <br>
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="table-responsive scroll-sm">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Code Order</th>
                                    <th>Product</th>
                                    <th>Customer</th>
                                    <th>Total Product</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            @foreach ($order_shipping_list as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $order->order->code_order ?? 'No Order' }}</td>
                                    <td>{{ $order->order->product->name_product ?? 'No Product' }}</td>
                                    <td>{{ $order->order->user->name ?? 'No Customer' }}</td>
                                    <td>{{ $order->order->qty ?? '0' }} Set</td>
                                    <td>
                                        <a href="{{ route('order-shipping-delete', ['id' => $order['id']]) }}"
                                            class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center"
                                            onclick="return confirm('Are you sure want to delete?')">
                                            <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                        </a>
                                    </td>

                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
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
                <form method="POST" action="{{ route('order-shipping-list-update') }}">
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
                    <input type="hidden" name="code_shipping" id="code-shipping"
                        value="{{ $order_shipping->first()->code_shipping }}">

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
