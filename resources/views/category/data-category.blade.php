@extends('template.admin')

@section('admin-content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Category</h6>
        <ul class="d-flex align-items-center gap-2">
            {{-- <li class="fw-medium">
                <button type="button" class="btn btn-outline-success-600 radius-8 px-20 py-11">Add Users</button>
            </li> --}}
            {{-- <li>
                <a href="{{ route('add-category') }}" class="btn btn-warning radius-8 d-flex align-items-center gap-2">
                    <iconify-icon icon="mynaui:book-plus" class="menu-icon text-lg"></iconify-icon>
                    <span>Add Category</span>
                </a>

            </li> --}}

        </ul>
    </div>

    <div class="card basic-data-table">
        <div class="card-header">
            <form action="{{ route('save-category') }}" method="POST" class="row gy-3 needs-validation" novalidate>
                @csrf
                <div class="col-md-9">
                    <input type="name" name="name" class="form-control @error('name') is-invalid @enderror"
                        placeholder="Enter Name Category" value="{{ old('name') }}">

                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-3 text-center">
                    <button type="submit"
                        class="btn btn-danger-600 radius-8 d-flex align-items-center justify-content-center gap-2 w-100">
                        <iconify-icon icon="mynaui:book-plus" class="menu-icon text-lg"></iconify-icon>
                        <span>Add Category</span>
                    </button>
                </div>

            </form>
        </div>
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
                        <th scope="col">Category</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody align="center">
                    @foreach ($data_category as $data)
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
                                    <img src="assets/images/category-icon.png" width="30px" alt=""
                                        class="flex-shrink-0 me-12 radius-8">
                                    <h6 class="text-md mb-0 fw-medium flex-grow-1">{{ $data['name_category'] }}</h6>
                                </div>
                            </td>
                            <td>{{ $data['created_at']->diffForHumans() }}</td>
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
                                    class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center edit-category"
                                    data-id="{{ $data['id'] }}" data-name="{{ $data['name_category'] }}">
                                    <iconify-icon icon="lucide:edit"></iconify-icon>
                                </a>


                                <a href="{{ route('delete-category', ['id' => $data['id']]) }}"
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


    <!-- Modal Update Category -->
    <div class="modal fade" id="updateCategoryModal" tabindex="-1" aria-labelledby="updateCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateCategoryModalLabel">Update Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="updateCategoryForm" method="POST" action="{{ route('update-category') }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <div class="mb-3">
                            <label for="name_category" class="form-label">Category Name</label>
                            <input type="text" id="name_category" name="name_category"
                                class="form-control @error('name_category') is-invalid @enderror"
                                placeholder="Enter Name Category" value="{{ old('name_category') }}">

                            @error('name_category')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
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

    <!-- Your custom script -->
    <script>
        $(document).ready(function() {
            // Ketika tombol edit di modal update ditekan
            $('.edit-category').on('click', function() {
                var id_category = $(this).data('id');
                var name = $(this).data('name');

                // Set data ke modal
                $('#id').val(id_category);
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
