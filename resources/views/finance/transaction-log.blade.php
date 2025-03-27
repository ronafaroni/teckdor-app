@extends('template.finance')

@section('finance-content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Transaction Log</h6>
        <ul class="d-flex align-items-center gap-2">
            {{-- <li class="fw-medium">
            <button type="button" class="btn btn-outline-success-600 radius-8 px-20 py-11">Add Users</button>
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

            <table class="table table-responsive bordered-table" id="dataTable" data-page-length='10'>
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">Date</th>
                        <th scope="col">Code Order</th>
                        <th scope="col">Product</th>
                        <th scope="col">Customer</th>
                        <th scope="col">Price</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody align="center">
                    @foreach ($payment as $itemPayment)
                        <tr>
                            <td>
                                <div class="form-check style-check d-flex align-items-center">
                                    <label class="form-check-label">
                                        {{ $loop->iteration }}
                                    </label>
                                </div>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($itemPayment->payment_date)->format('d M Y H:i:s') }}</td>
                            <td>{{ $itemPayment->code_order }}</td>
                            <td>{{ $itemPayment->order->product->name_product ?? 'N/A' }}</td>
                            <td>{{ $itemPayment->order->user->name ?? 'N/A' }}</td>
                            <td>{{ 'Rp. ' . number_format($itemPayment->total_payment) }}</td>
                            <td>
                                @if ($itemPayment->payment_status == 'fully paid')
                                    <span class="fw-medium">
                                        <span
                                            class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">
                                            Fully Paid
                                        </span>
                                    </span>
                                @else
                                    <span class="fw-medium">
                                        <span
                                            class="bg-danger-focus text-danger-main px-24 py-4 rounded-pill fw-medium text-sm">
                                            Partially Paid
                                        </span>
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach


                </tbody>

            </table>
        </div>
    </div>
@endsection



<!-- Modal Update Category -->
{{-- <div class="modal fade" id="detailProductModal" tabindex="-1" aria-labelledby="detailProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateCategoryModalLabel">Detail Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="updateCategoryForm" method="POST" action="{{ route('update-category') }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="id_category" id="id_category">
                        <div class="mb-3">
                            <label for="name_category" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="name_category" name="name_category" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}

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
