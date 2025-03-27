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
                    <p class="text-sm text-muted mb-1">Transaction ID</p>
                    <span class="fw-medium">INV.{{ $order->first()->code_order ?? 'N/A' }}</span>
                </div>

                <div class="col-md-3 d-flex flex-column">
                    <p class="text-sm text-muted mb-1">Customer Name</p>
                    <span class="fw-medium">{{ $order->first()->user->name ?? 'Unknown' }}</span>
                </div>

                <div class="col-md-3 d-flex flex-column">
                    <p class="text-sm text-muted mb-1">Total Order</p>
                    <span class="fw-medium">
                        Rp. {{ number_format(num: $order->total_payment * $order->qty) }}
                    </span>
                </div>

                <div class="col-md-3 d-flex flex-column">
                    <p class="text-sm text-muted mb-1">Order Date</p>
                    <span class="fw-medium">{{ $order->first()->created_at->format('d M Y h:i:s') ?? 'Unknown' }}</span>
                </div>
            </div>
            <br>
            <div class="row mt-4">
                <div class="col-md-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product List</th>
                                <th>Total Payment</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        @foreach ($detail_order as $order)
                            <tr>
                                <td colspan="1">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <!-- Gambar dan detail produk -->
                                        <div class="d-flex flex-column align-items-end justify-content-center">
                                            <img src="{{ asset('storage/' . $order->product->thumbnail) }}"
                                                alt="Product Image" class="flex-shrink-0 me-3 radius-8"
                                                style="width: 90px; height: 80px; object-fit: cover; border-radius: 8px; margin-left: 20px;">
                                        </div>
                                        <div class="flex-grow-1">
                                            <span class="text-muted text-sm d-block mb-2">
                                                Supplier >
                                                {{ optional($order->product->supplier)->name_supplier ?? 'No Supplier' }}
                                            </span>
                                            <h6 class="text-xl fw-medium mb-2">
                                                {{ $order->product->name_product }}
                                            </h6>
                                            <span class="text-muted text-sm d-block">
                                                <strong>Order : </strong> {{ $order->qty }} Set X Rp.
                                                {{ number_format($order->total_payment) }}
                                            </span>
                                        </div>

                                    </div>
                                </td>
                                <td>{{ 'Rp. ' . number_format($order->total_payment * $order->qty) }}</td>
                                <td>
                                    @if ($order->payment_status == 'Paid')
                                        <span class="fw-medium">
                                            <span
                                                class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">
                                                Paid Payment
                                            </span>
                                        </span>
                                    @else
                                        <span class="fw-medium">
                                            <span
                                                class="bg-danger-focus text-danger-main px-24 py-4 rounded-pill fw-medium text-sm">
                                                Unpaid Payment
                                            </span>
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
