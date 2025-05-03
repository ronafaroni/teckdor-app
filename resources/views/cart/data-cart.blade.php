@extends('template.customer')

@section('customer-content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Cart</h6>
        <ul class="d-flex align-items-center gap-2">

        </ul>
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
            @if ($data_cart->isEmpty())
                <!-- Tampilkan card kosong jika data tidak ada -->
                <div class="card basic-data-table mb-3 p-3">
                    <div class="card-body text-center">
                        <p class="text-muted">No products cart available.</p>
                    </div>
                </div>
            @else
                @foreach ($data_cart as $itemCart)
                    <div class="card basic-data-table mb-3 p-3">
                        <div class="card-body scrollable-content"> <!-- Tambahkan class scrollable-content -->
                            <div class="d-flex align-items-center justify-content-between">
                                <!-- Checkbox -->
                                <div class="d-flex flex-column align-items-end justify-content-center">
                                    <div class="form-check style-check d-flex align-items-center">
                                        <input class="form-check-input product-checkbox" type="checkbox"
                                            name="product_ids[]" value="{{ $itemCart->id }}" style="transform: scale(1.5);">
                                    </div>
                                </div>
                                <!-- Gambar dan detail produk -->
                                <div class="d-flex flex-column align-items-end justify-content-center">
                                    <img src="{{ asset('storage/' . $itemCart->product->thumbnail) }}" alt="Product Image"
                                        class="flex-shrink-0 me-3 radius-8"
                                        style="width: 120px; height: 100px; object-fit: cover; border-radius: 8px; margin-left: 20px;">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-medium mb-1">{{ $itemCart->product->name_product }}</h6>
                                    <span class="text-muted">Order: {{ $itemCart->qty }} Set</span>
                                </div>
                                <div class="d-flex flex-column align-items-end justify-content-between">
                                    <div class="d-flex justify-content-between gap-1 w-100">

                                        <!-- Tombol Edit -->
                                        <a href="{{ route('edit-cart', $itemCart->id) }}"
                                            class="btn btn-warning radius-8 d-flex align-items-center justify-content-center gap-2">
                                            <iconify-icon icon="lucide:edit" class="menu-icon text-lg"></iconify-icon>
                                            <span>Edit</span>
                                        </a>

                                        <!-- Tombol Delete -->
                                        <a href="{{ route('delete-cart', $itemCart->id) }}"
                                            class="btn btn-danger radius-8 d-flex align-items-center justify-content-center gap-2"
                                            onclick="return confirm('Are you sure want to delete product cart ?')">
                                            <iconify-icon icon="mdi:trash-can-outline"
                                                class="menu-icon text-lg"></iconify-icon>
                                            <span>Delete</span>
                                        </a>
                                    </div>
                                    <br>
                                    <span class="text-muted mb-3 mx-3">
                                        {{ \Carbon\Carbon::parse($itemCart->created_at)->format('d M Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

        </div>

        <!-- Input tersembunyi untuk status -->
        <input type="hidden" name="status" value="submission">

        <!-- Tombol Submit untuk Order Checked -->
        <button type="submit" class="btn btn-dark radius-8 d-flex align-items-center justify-content-center gap-2"
            onclick="return confirm('Are you sure want to order now?')">
            <iconify-icon icon="lets-icons:check-fill" class="menu-icon text-lg"></iconify-icon>
            <span>Order Now</span>
        </button>
    </form>
    @endif
    </div>

    <script>
        // Tangani tombol "Order Now"
        document.querySelectorAll('.order-now-btn').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-product-id');
                if (confirm('Are you sure want to order now?')) {
                    // Buat form baru untuk mengirim data satu produk
                    const form = document.createElement('form');
                    form.action = "{{ route('orders-update') }}";
                    form.method = "POST";
                    form.style.display = 'none';

                    // Tambahkan CSRF token
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);

                    // Tambahkan method PUT
                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'PUT';
                    form.appendChild(methodInput);

                    // Tambahkan input untuk product_ids
                    const productIdInput = document.createElement('input');
                    productIdInput.type = 'hidden';
                    productIdInput.name = 'product_ids[]';
                    productIdInput.value = productId;
                    form.appendChild(productIdInput);

                    // Tambahkan input untuk status
                    const statusInput = document.createElement('input');
                    statusInput.type = 'hidden';
                    statusInput.name = 'status';
                    statusInput.value = 'submission';
                    form.appendChild(statusInput);

                    // Submit form
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });

        // Tangani tombol "Order Checked"
        document.getElementById('orderForm').addEventListener('submit', function(event) {
            const selectedProducts = document.querySelectorAll('.product-checkbox:checked');
            if (selectedProducts.length === 0) {
                alert('Please select at least one product to order.');
                event.preventDefault(); // Mencegah form dikirim
            }
        });
    </script>
@endsection
