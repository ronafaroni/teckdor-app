@extends('template.admin')

@section('admin-content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Supplier</h6>
        <ul class="d-flex align-items-center gap-2">
            {{-- <li class="fw-medium">
                <button type="button" class="btn btn-outline-success-600 radius-8 px-20 py-11">Add Users</button>
            </li> --}}
            <li>
                <button type="button" class="btn btn-dark radius-8 d-flex align-items-center gap-2 px-12"
                    data-bs-toggle="modal" data-bs-target="#addSupplierModal">
                    <iconify-icon icon="solar:user-id-broken" class="menu-icon text-lg"></iconify-icon>
                    <span>Add Supplier</span>
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
                <table class="table bordered-table" id="dataTable" data-page-length='10'>
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Name Supplier</th>
                            <th scope="col">Address</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody align="center">
                        @foreach ($data_supplier as $data)
                            <tr>
                                <td>
                                    <div class="form-check style-check d-flex align-items-center">
                                        <label class="form-check-label">
                                            {{ $loop->iteration }}
                                        </label>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="assets/images/supplier-icon.png" width="30px" alt=""
                                            class="flex-shrink-0 me-12 radius-8">
                                        <h6 class="text-md mb-0 fw-medium flex-grow-1">{{ $data['name_supplier'] }}</h6>
                                    </div>
                                </td>
                                <td>{{ $data['address'] }}</td>
                                <td>{{ $data['phone'] }}</td>
                                <td>
                                    {{-- <a href="javascript:void(0)"
                                    class="w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center">
                                    <iconify-icon icon="iconamoon:eye-light"></iconify-icon>
                                </a> --}}
                                    {{-- <a href="{{ route('edit-category', ['id' => $data['id_category']]) }}"
                                    class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                    <iconify-icon icon="lucide:edit"></iconify-icon>
                                </a> --}}
                                    <a href="javascript:void(0)"
                                        class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center edit-supplier"
                                        data-id="{{ $data['id'] }}" data-name="{{ $data['name_supplier'] }}"
                                        data-address="{{ $data['address'] ?? '' }}"
                                        data-phone="{{ $data['phone'] ?? '' }}">
                                        <iconify-icon icon="lucide:edit"></iconify-icon>
                                    </a>

                                    <a href="{{ route('delete-supplier', ['id' => $data['id']]) }}"
                                        class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center"
                                        onclick="return confirm('Are you sure want to delete?')">
                                        <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                    </a>
                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Supplier -->
    <div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="addSupplierModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSupplierModalLabel">Add New Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('save-supplier') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Supplier Name</label>
                            <input type="text" name="name" autocomplete="off" placeholder="Enter Supplier Name"
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea name="address" autocomplete="off" placeholder="Enter Address"
                                class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}"></textarea>

                            @error('address')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="number" name="phone" autocomplete="off" placeholder="Enter Phone Number"
                                class="form-control @error('phone') is-invalid @enderror">

                            @error('phone')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Save Supplier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Update Category -->
    <div class="modal fade" id="updateSupplierModal" tabindex="-1" aria-labelledby="updateSupplierModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateSupplierModalLabel">Update Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="updateSupplierForm" method="POST" action="{{ route('update-supplier') }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <div class="mb-3">
                            <label for="name_supplier" class="form-label">Supplier Name</label>
                            <input type="text" class="form-control" id="name_supplier" name="name_supplier"
                                autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea type="text" class="form-control" id="address" name="address" autocomplete="off" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="number" class="form-control" id="phone" name="phone" autocomplete="off"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Update Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include Bootstrap JS (should be after jQuery) -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> --}}

    <script>
        $(document).ready(function() {
            // Ketika tombol edit di modal update ditekan
            $('.edit-supplier').on('click', function() {
                var id = $(this).data('id');
                var name = $(this).data('name');
                var address = $(this).data('address');
                var phone = $(this).data('phone');

                // Set data ke modal
                $('#id').val(id);
                $('#name_supplier').val(name);
                $('#address').val(address);
                $('#phone').val(phone);

                // Tampilkan modal update
                $('#updateSupplierModal').modal('show');
            });

            // Reset form tambah saat modal update ditutup
            $('#updateSupplierModal').on('hidden.bs.modal', function() {
                // Mengosongkan form update setelah modal ditutup
                $('#updateSupplierForm')[0].reset();

            });

            // Tambahkan event submit untuk form tambah, reset form setelah submit
            $('#addSupplierForm').on('submit', function() {
                // Reset form setelah submit (setelah data berhasil ditambahkan)
                $('#addSupplierForm')[0].reset();
            });
        });
    </script>
@endsection
