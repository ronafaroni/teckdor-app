@extends('template.admin')

@section('admin-content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Order List</h6>
        <ul class="d-flex align-items-center gap-2">

        </ul>
    </div>

    <div class="card basic-data-table">
        {{-- <div class="card-header">
            <h5 class="card-title mb-0">Default Datatables</h5>
        </div> --}}
        <div class="card-body">

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

            <div class="table-responsive scroll-sm">
                <table class="table bordered-table mb-0">
                    <thead>
                        <tr>
                            <th>Order Product</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($orders) > 0)
                            @foreach ($orders as $supplierName => $orderGroup)
                                <!-- Menampilkan Nama Supplier -->
                                <tr class="table-secondary">
                                    <td colspan="5">
                                        <strong>Supplier: {{ $supplierName }}</strong>
                                    </td>
                                </tr>

                                <!-- Menampilkan Produk dari Supplier Tersebut -->
                                @foreach ($orderGroup as $index => $order)
                                    <tr>
                                        <td colspan="1">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <!-- Gambar dan detail produk -->
                                                <div class="d-flex flex-column align-items-end justify-content-center">
                                                    <img src="{{ asset('storage/' . $order->product->thumbnail) }}"
                                                        alt="Product Image" class="flex-shrink-0 me-3 radius-8"
                                                        style="width: 120px; height: 90px; object-fit: cover; border-radius: 8px; margin-left: 20px;">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span
                                                        class="text-muted text-sm">{{ \Carbon\Carbon::parse($order->updated_at)->diffForHumans() }}</span>
                                                    <h6 class="fw-medium mb-1">{{ $order->product->name_product }}</h6>
                                                    <span class="text-muted">Order: {{ $order->qty }} Set</span>
                                                </div>
                                            </div>
                                        </td>

                                        <td>{{ $order->user->name }}</td>
                                        <td>{{ $order->created_at->format('d M Y') }}</td>
                                        <td>
                                            <!-- Tombol Order Now -->
                                            <button type="button"
                                                class="btn btn-dark radius-8 d-flex align-items-center justify-content-center gap-2 order-now-btn"
                                                data-bs-toggle="modal" data-bs-target="#orderModal{{ $order->id }}">
                                                <iconify-icon icon="icon-park-outline:view-grid-detail"
                                                    class="menu-icon text-lg"></iconify-icon>
                                                <span>Order Approve</span>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    <strong>No Orders Available</strong>
                                </td>
                            </tr>
                        @endif

                    </tbody>
                </table>
            </div>

        </div>
    </div>

    @foreach ($orders as $supplierName => $orderGroup)
        @foreach ($orderGroup as $index => $order)
            <!-- Modal Approve order -->
            <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1"
                aria-labelledby="updateCategoryModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Order Approved</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="{{ route('order-approve', $order->id) }}">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Total Payment</label>
                                    <input type="number" name="payment"
                                        class="form-control @error('payment') is-invalid @enderror"
                                        placeholder="Enter Total Payment" value="{{ old('payment') }}">

                                    @error('payment')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-danger">Approve</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @endforeach
@endsection
