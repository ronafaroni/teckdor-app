@extends('template.admin')

@section('admin-content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Finishing</h6>
        <ul class="d-flex align-items-center gap-2">
            {{-- <li class="fw-medium">
                <button type="button" class="btn btn-outline-success-600 radius-8 px-20 py-11">Add Users</button>
            </li> --}}
            <li>
                <button type="button" class="btn btn-dark radius-8 d-flex align-items-center gap-2 px-12"
                    data-bs-toggle="modal" data-bs-target="#addFinishing">
                    <iconify-icon icon="mdi:progress-pencil" class="menu-icon text-lg"></iconify-icon>
                    <span>Add Finishing</span>
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
                <table class="table bordered-table mb-0" id="dataTable" data-page-length='10'>
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Name Finishing</th>
                            <th scope="col">Date</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody align="center">
                        @foreach ($finishing as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->created_at->format('d F Y H:i:s') }}</td>
                                <td>
                                    <a href="javascript:void(0)"
                                        class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center edit-supplier"
                                        data-bs-toggle="modal" data-bs-target="#editFinishing{{ $item['id'] }}">
                                        <iconify-icon icon="lucide:edit"></iconify-icon>
                                    </a>

                                    <a href="{{ route('data-finishing-delete', ['id' => $item['id']]) }}"
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

    <!-- Modal Update Category -->
    <div class="modal fade" id="addFinishing" tabindex="-1" aria-labelledby="addFinishingLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateSupplierModalLabel">Add Finishing</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="updateSupplierForm" method="POST" action="{{ route('order-finishing') }}">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <div class="mb-3">
                            <label for="finishing_name" class="form-label">Finishing Name</label>
                            <input type="text" class="form-control" id="finishing_name" name="finishing_name"
                                autocomplete="off">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Add Finishing</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($finishing as $item)
        <div class="modal fade" id="editFinishing{{ $item['id'] }}" tabindex="-1"
            aria-labelledby="addProgressSettingLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateSupplierModalLabel">Edit Finishing</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="updateSupplierForm" method="POST"
                        action="{{ route('order-finishing-update', $item['id']) }}">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="id" id="id">
                            <div class="mb-3">
                                <label for="progress_name" class="form-label">Finishing Name</label>
                                <input type="text" class="form-control" id="finishing_name" name="finishing_name"
                                    autocomplete="off" value="{{ $item->name }}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Update Finishing</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
