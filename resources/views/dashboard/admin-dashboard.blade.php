@extends('template.admin')

@section('admin-content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Dashboard</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
        </ul>
    </div>

    <div class="row gy-4">
        <div class="col">
            <div class="card radius-8 border-0">
                <div class="row">

                    <div class="row h-100 g-0">
                        <div class="col-4 p-0 m-0">
                            <div class="card-body p-24 h-100 d-flex flex-column justify-content-center border border-top-0">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                    <div>
                                        <span
                                            class="mb-12 w-44-px h-44-px text-primary-600 bg-primary-light border border-primary-light-white flex-shrink-0 d-flex justify-content-center align-items-center radius-8 h6 mb-12">
                                            <iconify-icon icon="fa-solid:box-open" class="icon"></iconify-icon>
                                        </span>
                                        <span class="mb-1 fw-medium text-secondary-light text-md">Total
                                            Products</span>
                                        <h6 class="fw-semibold text-primary-light mb-1">
                                            @php
                                                $totalStock = 0; // Variabel untuk menyimpan total keseluruhan
                                            @endphp

                                            @foreach ($product as $item)
                                                @php
                                                    // Hitung total stok untuk setiap produk
                                                    $itemTotal =
                                                        ($item->product_stocks_sum_stock ?? 0) +
                                                        ($item->stock ?? 0) +
                                                        ($item->orders_sum_qty ?? 0);

                                                    // Tambahkan ke total keseluruhan
                                                    $totalStock += $itemTotal;
                                                @endphp
                                            @endforeach
                                            {{ $totalStock }}

                                        </h6>
                                    </div>
                                </div>
                                {{-- <p class="text-sm mb-0">Increase by <span
                                            class="bg-success-focus px-1 rounded-2 fw-medium text-success-main text-sm">+200</span>
                                        this week</p> --}}
                            </div>
                        </div>
                        <div class="col-4 p-0 m-0">
                            <div
                                class="card-body p-24 h-100 d-flex flex-column justify-content-center border border-top-0 border-start-0 border-end-0">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                    <div>
                                        <span
                                            class="mb-12 w-44-px h-44-px text-yellow bg-yellow-light border border-yellow-light-white flex-shrink-0 d-flex justify-content-center align-items-center radius-8 h6 mb-12">
                                            <iconify-icon icon="flowbite:users-group-solid" class="icon"></iconify-icon>
                                        </span>
                                        <span class="mb-1 fw-medium text-secondary-light text-md">Total
                                            Customer</span>
                                        <h6 class="fw-semibold text-primary-light mb-1">
                                            {{ $customerCount }}
                                        </h6>
                                    </div>
                                </div>
                                {{-- <p class="text-sm mb-0">Increase by <span
                                            class="bg-danger-focus px-1 rounded-2 fw-medium text-danger-main text-sm">-5k</span>
                                        this week</p> --}}
                            </div>
                        </div>
                        <div class="col-4 p-0 m-0">
                            <div
                                class="card-body p-24 h-100 d-flex flex-column justify-content-center border border-top-0 border-bottom-0">
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                    <div>
                                        <span
                                            class="mb-12 w-44-px h-44-px text-pink bg-pink-light border border-pink-light-white flex-shrink-0 d-flex justify-content-center align-items-center radius-8 h6 mb-12">
                                            <iconify-icon icon="majesticons:shopping-cart" class="icon"></iconify-icon>
                                        </span>
                                        <span class="mb-1 fw-medium text-secondary-light text-md">Total
                                            Orders</span>
                                        <h6 class="fw-semibold text-primary-light mb-1">
                                            {{ $orderCount }}
                                        </h6>
                                    </div>
                                </div>
                                {{-- <p class="text-sm mb-0">Increase by <span
                                            class="bg-success-focus px-1 rounded-2 fw-medium text-success-main text-sm">+1k</span>
                                        this week</p> --}}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-xxl-12 col-lg-12">
            <div class="card h-100">
                <div class="card-body p-24">
                    <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between mb-20">
                        <h6 class="mb-2 fw-bold text-lg mb-0">Recent Orders</h6>
                        <a href="{{ route('order-log') }}"
                            class="text-primary-600 hover-text-primary d-flex align-items-center gap-1">
                            View All
                            <iconify-icon icon="solar:alt-arrow-right-linear" class="icon"></iconify-icon>
                        </a>
                    </div>
                    <div class="table-responsive scroll-sm">
                        <table class="table bordered-table mb-0">
                            <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Code Order</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Customer</th>
                                    <th scope="col">Total Payment</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody align="center">
                                @foreach ($orderLog as $codeOrder => $dataOrders)
                                    @php
                                        $firstOrder = $dataOrders->first();
                                        $totalProducts = $dataOrders->count();
                                        $totalPayment = $dataOrders->sum('total_payment');
                                        $qty = $dataOrders->sum('qty');
                                        $status = $dataOrders->first()->payment_status;
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="form-check style-check d-flex align-items-center">
                                                <label class="form-check-label">
                                                    {{ $loop->iteration }}
                                                </label>
                                            </div>
                                        </td>
                                        <td>{{ $firstOrder->created_at->format('d M Y H:i:s') }}</td>
                                        <td>{{ $codeOrder }}</td>
                                        <td>{{ $totalProducts }} X Product</td>
                                        <td>{{ optional($firstOrder->user)->name ?? 'No User' }}</td>
                                        <td>{{ 'Rp. ' . number_format($totalPayment * $qty) }}</td>
                                        <td>
                                            <a href="{{ route('order-detail', $codeOrder) }}"
                                                class="btn btn-sm btn-dark radius-8 d-flex align-items-center justify-content-center gap-2"
                                                style="padding: 8px 16px; font-size: 14px;">
                                                <iconify-icon icon="bx:detail" class="menu-icon text-lg"></iconify-icon>
                                                <span>Detail Transaction</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
