@extends('template.admin')

@section('admin-content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Log Orders</h6>
        <ul class="d-flex align-items-center gap-2">
            {{-- <li class="fw-medium">
                <button type="button" class="btn btn-outline-success-600 radius-8 px-20 py-11">Add Users</button>
            </li> --}}
            {{-- <li>
                <a href="{{ route('report-log-export') }}" class="btn btn-dark radius-8 d-flex align-items-center gap-2">
                    <iconify-icon icon="tdesign:file-1" class="menu-icon text-lg"></iconify-icon>
                    <span>Report</span>
                </a>

            </li> --}}
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

            <form action="{{ route('search-log') }}" method="POST" class="row gy-3 needs-validation" novalidate>
                @csrf

                <div class="col-md-5">
                    <input type="date" name="date_awal" class="form-control @error('price') is-invalid @enderror"
                        placeholder="Enter Date First" value="{{ old('date_awal') }}">

                    @error('price')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-md-5">
                    <input type="date" name="date_akhir" class="form-control @error('stock') is-invalid @enderror"
                        placeholder="Enter Date Last" value="{{ old('date_akhir') }}">

                    @error('stock')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-danger radius-8 d-flex align-items-center gap-2">
                        <iconify-icon icon="ix:product-search" class="menu-icon text-lg"></iconify-icon>
                        <span>Search</span>
                    </button>
                </div>

            </form>

            <br>
            @if (isset($orders))
                @if (request()->has('date_awal') && request()->has('date_akhir') && count($orders) > 0)
                    <div class="col-lg-2 mb-16">
                        <a href="{{ route('report-log-export', ['start_date' => request('date_awal'), 'end_date' => request('date_akhir')]) }}"
                            class="btn btn-dark d-flex align-items-center justify-content-center gap-6 px-8 py-6">
                            <iconify-icon icon="tdesign:file-1" class="menu-icon text-lg"></iconify-icon>
                            <span class="d-flex align-items-center">Report</span>
                        </a>
                    </div>
                @endif

                <div class="table-responsive scroll-sm">
                    <table class="table bordered-table mb-0" id="dataTable" data-page-length='10'>
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
                            @foreach ($orders as $codeOrder => $dataOrders)
                                @php
                                    $firstOrder = $dataOrders->first();
                                    $totalProducts = $dataOrders->count();
                                    $totalPayment = $dataOrders->sum('total_payment');
                                    $qty = $dataOrders->sum('qty');
                                    $status = $dataOrders->first()->payment_status;
                                    $orderDate = \Carbon\Carbon::parse($firstOrder->order_date)->format('d M Y');
                                @endphp
                                <tr>
                                    <td>
                                        <div class="form-check style-check d-flex align-items-center">
                                            <label class="form-check-label">
                                                {{ $loop->iteration }}
                                            </label>
                                        </div>
                                    </td>
                                    <td>{{ $orderDate }}</td>
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
            @endif
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
