@extends('template.finance')

@section('finance-content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Transaction Detail</h3>
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
                    <span class="fw-medium">INV.{{ $transactions->first()->code_order ?? 'N/A' }}</span>
                </div>

                <div class="col-md-3 d-flex flex-column">
                    <p class="text-sm text-muted mb-1">Customer Name</p>
                    <span class="fw-medium">{{ $transactions->first()->user->name ?? 'Unknown' }}</span>
                </div>

                <div class="col-md-3 d-flex flex-column">
                    <p class="text-sm text-muted mb-1">Total Order</p>
                    <span class="fw-medium">
                        Rp. {{ number_format($transactions->sum(fn($order) => $order->total_payment * $order->qty)) }}
                    </span>
                </div>

                <div class="col-md-3 flex-column flex-grow-1">
                    <p class="text-sm text-muted mb-1">Status Payment</p>
                    @if ($transactions->first()->payment_status == 'Paid')
                        <span class="fw-medium">
                            <span class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">
                                Paid Payment
                            </span>
                        </span>
                    @else
                        <span class="fw-medium">
                            <span class="bg-danger-focus text-danger-main px-24 py-4 rounded-pill fw-medium text-sm">
                                Unpaid Payment
                            </span>
                        </span>
                    @endif
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
                            </tr>
                        </thead>
                        @foreach ($transactions as $order)
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
                            </tr>
                            {{-- <tr>
                                <td>{{ 'Rp. ' . number_format($order->total_payment * $order->qty) }}</td>
                            </tr> --}}
                        @endforeach
                    </table>
                    {{-- <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Order Date</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total Payment</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $order)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('storage/' . ($order->product->thumbnail ?? 'default.jpg')) }}"
                                                alt="Product Image"
                                                style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; margin-right: 10px;">
                                            <span>{{ $order->product->name_product ?? 'No Product' }}</span>
                                        </div>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y H:i:s') }}</td>
                                    <td>{{ $order->qty }} Set</td>
                                    <td>Rp. {{ number_format($order->product->price ?? 0) }}</td>
                                    <td>Rp. {{ number_format($order->total_payment * $order->qty) }}</td>
                                    <td>
                                        <span
                                            class="bg-danger-focus text-danger-main px-24 py-4 rounded-pill fw-medium text-sm">
                                            Unpaid Payment
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table> --}}
                </div>
            </div>

            <div id="alertContainer"></div>

            <div class="row mt-4">
                <div class="card">
                    <!-- Tempat Menampilkan Alert -->
                    <div id="alertContainer"></div>

                    <div class="card-body">
                        <table class="table" id="transactionTable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Date</th>
                                    <th>Total Payment</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payment as $dataItem)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ \Carbon\Carbon::parse($dataItem->payment_date)->format('d M Y H:i:s') }}
                                        </td>
                                        <td>Rp. {{ number_format($dataItem->total_payment) }}</td>
                                        <td>
                                            @if ($dataItem->payment_status == 'partially paid')
                                                <span
                                                    class="bg-danger-focus text-danger-main px-24 py-4 rounded-pill fw-medium text-sm">
                                                    Partially Paid
                                                </span>
                                            @else
                                                <span
                                                    class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">
                                                    Fully Paid
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button"
                                                class="btn btn-danger btn-sm radius-8 d-flex align-items-center justify-content-center gap-2"
                                                id="deleteButton{{ $dataItem->id }}">
                                                <iconify-icon icon="material-symbols:delete-rounded"
                                                    class="menu-icon text-lg"></iconify-icon>
                                                Delete
                                            </button>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        Total Payment: <b> {{ 'Rp. ' . number_format($payment->sum('total_payment'), 0, ',', '.') }}</b>
                    </div>
                </div>
            </div>
            @php
                // Hitung total order dan total payment tanpa format
                $total_order = $transactions->sum(fn($order) => $order->total_payment * $order->qty);
                $total_payment = $payment->sum('total_payment');
            @endphp

            <div class="col-md-12 d-flex justify-content-center gap-2 mt-8">
                <!-- Tombol Add Payment -->
                <button type="button" class="btn btn-dark radius-8 d-flex align-items-center justify-content-center gap-2"
                    data-bs-toggle="modal" data-bs-target="#paymentModal{{ $order->id }}"
                    @if ($total_payment >= $total_order) disabled @endif>
                    <iconify-icon icon="ic:baseline-payments" class="menu-icon text-lg"></iconify-icon>
                    <span>Add Payment</span>
                </button>

                <!-- Tombol Paid Payment -->
                <button type="button"
                    class="btn btn-danger radius-8 d-flex align-items-center justify-content-center gap-2 order-now-btn"
                    data-code-order="{{ $order->code_order }}" @if ($total_payment < $total_order) disabled @endif>
                    <iconify-icon icon="lets-icons:check-fill" class="menu-icon text-lg"></iconify-icon>
                    <span>Paid Payment</span>
                </button>
            </div>

        </div>
    </div>

    @foreach ($transactions as $order)
        <div class="modal fade" id="paymentModal{{ $order->id }}" tabindex="-1" aria-labelledby="productModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="productModalLabel">Add Payment</h5>
                        <button type="button" aria-hidden="true" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <form class="payment-form" action="{{ route('transaction-payment') }}" method="POST"
                                class="row gy-3 needs-validation" enctype="multipart/form-data" novalidate>
                                @csrf

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Total Payment</label>
                                    <input type="number" name="total_payment" min="0" class="form-control"
                                        placeholder="Enter Total Payment" required>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Status Payment</l>
                                        <div class="d-flex align-items-center flex-wrap gap-2">
                                            <div class="form-check checked-danger d-flex align-items-center gap-2">
                                                <input class="form-check-input" type="radio" name="status_payment"
                                                    value="unpaid" checked>
                                                <label class="form-check-label">Unpaid</label>
                                            </div>
                                            <div class="form-check checked-danger d-flex align-items-center gap-2">
                                                <input class="form-check-input" type="radio" name="status_payment"
                                                    value="partially paid">
                                                <label class="form-check-label">Partially Paid</label>
                                            </div>
                                            <div class="form-check checked-danger d-flex align-items-center gap-2">
                                                <input class="form-check-input" type="radio" name="status_payment"
                                                    value="fully paid">
                                                <label class="form-check-label">Fully Paid</label>
                                            </div>
                                        </div>
                                </div>

                                <input type="hidden" name="code_order" value="{{ $order->code_order }}">
                                <input type="hidden" name="order_id" value="{{ $order->id }}">

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-danger">Add Payment</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Periksa apakah ada pesan alert yang tersimpan di localStorage
            const alertMessage = localStorage.getItem("alertMessage");
            if (alertMessage) {
                // Tampilkan alert dari localStorage jika ada
                const alertType = localStorage.getItem("alertType");
                showAlert(alertMessage, alertType);
                // Hapus pesan setelah ditampilkan
                localStorage.removeItem("alertMessage");
                localStorage.removeItem("alertType");
            }

            // Gunakan event delegation untuk menangani form di dalam modal
            document.querySelectorAll(".payment-form").forEach(function(form) {
                form.addEventListener("submit", function(event) {
                    event.preventDefault(); // Mencegah reload halaman

                    let formData = new FormData(this);

                    fetch("{{ route('transaction-payment') }}", {
                            method: "POST",
                            body: formData,
                            headers: {
                                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]')
                                    .value
                            }
                        })
                        .then(response => response.json()) // Ambil JSON dari respons
                        .then(data => {
                            console.log(data); // Untuk debugging, melihat data yang diterima
                            if (data.message) {
                                // Menyimpan pesan alert di localStorage
                                localStorage.setItem("alertMessage", data.message);
                                localStorage.setItem("alertType", "success");

                                // Menutup modal setelah sukses
                                let modalId = "#paymentModal" + data
                                    .id; // Dapatkan modal berdasarkan id
                                let modal = document.querySelector(modalId);
                                if (modal) {
                                    let bootstrapModal = new bootstrap.Modal(
                                        modal); // Menggunakan Bootstrap Modal
                                    bootstrapModal.hide(); // Menutup modal
                                }

                                // Reload halaman untuk update konten terbaru tanpa pindah halaman
                                location.reload(); // Reload halaman
                            } else {
                                showAlert("Unexpected response structure.", "danger");
                            }
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            showAlert("An error occurred while processing the payment.",
                                "danger");
                        });
                });
            });

            // Function to show alert messages
            function showAlert(message, type) {
                let alertContainer = document.getElementById("alertContainer"); // Menyimpan alert di sini
                alertContainer.innerHTML = `
                    <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                        <strong>${message}</strong>
                        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Gunakan event delegation untuk menangani penghapusan
            document.querySelectorAll("[id^='deleteButton']").forEach(function(button) {
                button.addEventListener("click", function(event) {
                    // Dapatkan id data yang akan dihapus
                    const dataId = event.target.id.replace('deleteButton', '');

                    // Menampilkan konfirmasi sebelum penghapusan
                    const confirmDelete = window.confirm(
                        "Are you sure you want to delete this data?");
                    if (confirmDelete) {
                        // Kirim permintaan ke server untuk menghapus data
                        fetch(`/delete-transaction/${dataId}`, {
                                method: "DELETE",
                                headers: {
                                    "X-CSRF-TOKEN": document.querySelector(
                                        'input[name="_token"]').value
                                }
                            })
                            .then(response => response.json()) // Ambil JSON dari respons
                            .then(data => {
                                console.log(
                                    data); // Untuk debugging, melihat data yang diterima
                                if (data.message) {
                                    // Menyimpan pesan alert di localStorage
                                    localStorage.setItem("alertMessage", data.message);
                                    localStorage.setItem("alertType", "danger");

                                    // Reload halaman untuk update konten terbaru tanpa pindah halaman
                                    location.reload(); // Reload halaman untuk memperbarui data
                                } else {
                                    showAlert("Unexpected response structure.", "danger");
                                }
                            })
                            .catch(error => {
                                console.error("Error:", error);
                                showAlert("An error occurred while deleting the payment.",
                                    "danger");
                            });
                    }
                });
            });

            // Function to show alert messages
            function showAlert(message, type) {
                let alertContainer = document.getElementById("alertContainer");
                alertContainer.innerHTML = `
                <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                    <strong>${message}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            }

            // Periksa apakah ada pesan alert yang tersimpan di localStorage
            const alertMessage = localStorage.getItem("alertMessage");
            if (alertMessage) {
                // Tampilkan alert dari localStorage jika ada
                const alertType = localStorage.getItem("alertType");
                showAlert(alertMessage, alertType);
                // Hapus pesan setelah ditampilkan
                localStorage.removeItem("alertMessage");
                localStorage.removeItem("alertType");
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Tangani klik tombol untuk update status pembayaran
            document.querySelectorAll(".order-now-btn").forEach(function(button) {
                button.addEventListener("click", function() {
                    const codeOrder = button.getAttribute(
                        "data-code-order"); // Mengambil code_order

                    // Dialog konfirmasi sebelum melanjutkan pembaruan
                    const confirmAction = window.confirm(
                        "Are you sure you want to update the payment status for this order?");

                    // Jika user mengonfirmasi
                    if (confirmAction) {
                        // Kirim request untuk memperbarui status pembayaran
                        fetch(`/update-payment-status/${codeOrder}`, {
                                method: "POST",
                                headers: {
                                    "X-CSRF-TOKEN": document.querySelector(
                                        'input[name="_token"]').value,
                                    "Content-Type": "application/json"
                                },
                                body: JSON.stringify({}) // Data tambahan jika diperlukan
                            })
                            .then(response => response.json())
                            .then(data => {
                                // Menampilkan alert jika status pembayaran berhasil diperbarui
                                showAlert(data.message, "success");

                                // Jika status berhasil diperbarui, update semua baris dengan kode yang sama
                                if (data.orders && data.orders.length > 0) {
                                    data.orders.forEach(order => {
                                        const row = document.querySelector(
                                            `#orderRow${order.id}`);
                                        if (row) {
                                            // Update status pembayaran di baris tabel untuk setiap order yang diperbarui
                                            const statusCell = row.querySelector(
                                                ".payment-status");
                                            statusCell.innerHTML =
                                                `<span class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">Fully Paid</span>`;
                                        }
                                    });
                                }
                            })
                            .catch(error => {
                                console.error("Error:", error);
                                showAlert(
                                    "An error occurred while updating the payment status.",
                                    "danger");
                            });
                    }
                });
            });

            // Function to show alert messages
            function showAlert(message, type) {
                let alertContainer = document.getElementById("alertContainer"); // Menyimpan alert di sini
                alertContainer.innerHTML = `
                <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                    <strong>${message}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            }
        });
    </script>
@endsection
