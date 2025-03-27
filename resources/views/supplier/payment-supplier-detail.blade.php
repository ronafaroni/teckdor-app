@extends('template.finance')

@section('finance-content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Supplier Payment Detail</h3>
        </div>

        @if (session()->has('success'))
            <div class="mb-16">
                <div class="alert alert-success bg-success-100 text-success-600 border-success-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-0 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between"
                    role="alert">
                    <div class="d-flex align-items-center gap-2">
                        <iconify-icon icon="akar-icons:double-check" class="icon text-xl"></iconify-icon>
                        <span>{{ session()->get('success') }}</span>
                    </div>
                    <button class="remove-button text-success-600 text-xxl line-height-1">
                        <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon>
                    </button>
                </div>
            </div>
        @endif

        <div class="card-body">
            <div class="row mt-4">
                <div class="col-md-4 d-flex flex-column">
                    <p class="text-sm text-muted mb-1">Code Order</p>
                    <span class="fw-medium">{{ $payment->first()->code_order ?? 'N/A' }}</span>
                    <br>
                    <p class="text-sm text-muted mb-1">Product</p>
                    <span class="fw-medium">{{ $payment->first()->product->name_product ?? 'N/A' }}</span>
                </div>

                <div class="col-md-4 d-flex flex-column">
                    <p class="text-sm text-muted mb-1">Customer Name</p>
                    <span class="fw-medium">{{ $payment->first()->user->name ?? 'Unknown' }}</span>
                    <br>
                    <p class="text-sm text-muted mb-1">Supplier Name</p>
                    <span class="fw-medium">{{ $payment->first()->product->supplier->name_supplier ?? 'Unknown' }}</span>
                </div>

                <div class="col-md-4 d-flex flex-column">
                    <p class="text-sm text-muted mb-1">Total Order</p>
                    <span class="fw-medium">
                        Rp. {{ number_format($payment->first()->total_payment * $payment->first()->qty) }}
                    </span>
                    <br>
                    <p class="text-sm text-muted mb-1">Status Payment</p>
                    @if ($payment->first()->supplier_payment_status == 'paid')
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

            <div id="alertContainer"></div>

            <div class="row mt-4">
                <div class="card">
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
                                @foreach ($supplierPayment as $dataItem)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ \Carbon\Carbon::parse($dataItem->payment_date)->format('d M Y H:i:s') }}</td>
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
                        Total Payment: <b>
                            {{ 'Rp. ' . number_format($supplierPayment->sum('total_payment'), 0, ',', '.') }}</b>
                    </div>
                </div>
            </div>

            @php
                // Hitung total pembayaran yang sudah dilakukan
                $totalPaid = $supplierPayment->sum('total_payment');
                // Total yang dibutuhkan (misalnya dari $payment->total_payment)
                $totalNeeded = $payment->first()->total_payment * $payment->first()->qty;
            @endphp

            <div class="col-md-12 d-flex justify-content-center gap-2 mt-8">
                <!-- Tombol "Add Payment" -->
                {{-- <button type="button" class="btn btn-dark radius-8 d-flex align-items-center justify-content-center gap-2"
                    data-bs-toggle="modal" data-bs-target="#paymentModal{{ $payment->first()->product->id }}"
                    @if ($totalPaid >= $totalNeeded) disabled @endif>
                    <iconify-icon icon="ic:baseline-payments" class="menu-icon text-lg"></iconify-icon>
                    <span>Add Payment</span>
                </button> --}}
                <button type="button" class="btn btn-dark radius-8 d-flex align-items-center justify-content-center gap-2"
                    data-bs-toggle="modal" data-bs-target="#paymentModal{{ $payment->first()->product->id }}">
                    <iconify-icon icon="ic:baseline-payments" class="menu-icon text-lg"></iconify-icon>
                    <span>Add Payment</span>
                </button>

                <!-- Tombol "Paid Payment" -->
                <button type="button"
                    class="btn btn-danger radius-8 d-flex align-items-center justify-content-center gap-2 order-now-btn"
                    data-order-id="{{ $payment->first()->id }}" @if ($totalPaid < $totalNeeded) disabled @endif>
                    <iconify-icon icon="lets-icons:check-fill" class="menu-icon text-lg"></iconify-icon>
                    <span>Paid Payment</span>
                </button>
            </div>

            <!-- Modal untuk Add Payment -->
            @foreach ($payment as $itemPayment)
                <div class="modal fade" id="paymentModal{{ $itemPayment->product_id }}" tabindex="-1"
                    aria-labelledby="productModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="productModalLabel">Add Payment</h5>
                                <button type="button" aria-hidden="true" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="card-body">
                                    <form class="payment-form" action="{{ route('save-supplier-payment') }}" method="POST"
                                        enctype="multipart/form-data" novalidate>
                                        @csrf

                                        <!-- Input Total Payment -->
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Total Payment</label>
                                            <input type="number" name="total_payment" min="0" class="form-control"
                                                placeholder="Enter Total Payment" required>
                                        </div>

                                        <!-- Radio Button untuk Status Payment -->
                                        <div class="col-md-12">
                                            <label class="form-label">Status Payment</label>
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

                                        <!-- Hidden Inputs -->
                                        <input type="hidden" name="code_order" value="{{ $itemPayment->code_order }}">
                                        <input type="hidden" name="order_id" value="{{ $itemPayment->id }}">
                                        <input type="hidden" name="product_id" value="{{ $itemPayment->product->id }}">
                                        <input type="hidden" name="supplier_id"
                                            value="{{ $itemPayment->product->supplier->id }}">

                                        <!-- Tombol Submit dan Close -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-dark"
                                                data-bs-dismiss="modal">Close</button>
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

                            fetch("{{ route('save-supplier-payment') }}", {
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
                                fetch(`/delete-supplier-payment/${dataId}`, {
                                        method: "DELETE",
                                        headers: {
                                            "X-CSRF-TOKEN": document.querySelector(
                                                'input[name="_token"]').value,
                                            "Content-Type": "application/json",
                                            "Accept": "application/json"
                                        }
                                    })
                                    .then(response => {
                                        if (!response.ok) {
                                            throw new Error("Network response was not ok");
                                        }
                                        return response.json();
                                    })
                                    .then(data => {
                                        console.log(
                                            data); // Untuk debugging, melihat data yang diterima
                                        if (data.message) {
                                            // Menyimpan pesan alert di localStorage
                                            localStorage.setItem("alertMessage", data.message);
                                            localStorage.setItem("alertType", "success");

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
                            // Ambil order_id dari atribut data-order-id
                            const orderId = button.getAttribute("data-order-id");

                            // Dialog konfirmasi sebelum melanjutkan pembaruan
                            const confirmAction = window.confirm(
                                "Are you sure you want to update the payment status?");

                            // Jika user mengonfirmasi
                            if (confirmAction) {
                                // Kirim request untuk memperbarui status pembayaran
                                fetch(`/update-supplier-payment-status/${orderId}`, {
                                        method: "POST",
                                        headers: {
                                            "X-CSRF-TOKEN": document.querySelector(
                                                'input[name="_token"]').value,
                                            "Content-Type": "application/json"
                                        },
                                        body: JSON.stringify({}) // Data tambahan jika diperlukan
                                    })
                                    .then(response => {
                                        if (!response.ok) {
                                            throw new Error("Network response was not ok");
                                        }
                                        return response.json();
                                    })
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
                                                        ".supplier-payment-status");
                                                    statusCell.innerHTML =
                                                        `<span class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">Fully Paid</span>`;
                                                }
                                            });
                                        }

                                        // Nonaktifkan tombol "Add Payment" dan aktifkan tombol "Paid Payment"
                                        const addPaymentButton = document.querySelector(
                                            '[data-bs-target="#paymentModal{{ $payment->first()->product->id }}"]'
                                        );
                                        const paidPaymentButton = document.querySelector(
                                            ".order-now-btn");

                                        if (addPaymentButton && paidPaymentButton) {
                                            addPaymentButton.disabled =
                                                true; // Nonaktifkan tombol "Add Payment"
                                            paidPaymentButton.disabled =
                                                true; // Nonaktifkan tombol "Paid Payment" setelah status diperbarui
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
