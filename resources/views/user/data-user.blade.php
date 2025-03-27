@extends('template.admin')

@section('admin-content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Users Account</h6>
        <ul class="d-flex align-items-center gap-2">
            {{-- <li class="fw-medium">
                <button type="button" class="btn btn-outline-success-600 radius-8 px-20 py-11">Add Users</button>
            </li> --}}
            <li>
                <a href="{{ route('add-users') }}" class="btn btn-dark radius-8 d-flex align-items-center gap-2">
                    <iconify-icon icon="tdesign:user-add" class="menu-icon text-lg"></iconify-icon>
                    <span>Add User</span>
                </a>

            </li>

        </ul>
    </div>

    <div class="card basic-data-table">
        {{-- <div class="card-header">
            <h5 class="card-title mb-0">Default Datatables</h5>
        </div> --}}
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
                        <th scope="col">No. </th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Password</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data_user as $data)
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
                                    <img src="assets/images/user_icon2.png" width="25px" alt=""
                                        class="flex-shrink-0 me-12 radius-8">
                                    <h6 class="text-md mb-0 fw-medium flex-grow-1">{{ $data['name'] }}</h6>
                                </div>
                            </td>
                            <td>{{ $data['email'] }}</td>
                            <td>{{ str_repeat('*', min(strlen($data['password']), 8)) }}</td>

                            <td>
                                @if ($data['role'] == 'admin')
                                    <span
                                        class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">
                                        {{ $data['role'] }}
                                    </span>
                                @elseif ($data['role'] == 'customer')
                                    <span
                                        class="bg-warning-focus text-warning-main px-24 py-4 rounded-pill fw-medium text-sm">
                                        {{ $data['role'] }}
                                    </span>
                                @elseif ($data['role'] == 'finance')
                                    <span
                                        class="bg-danger-focus text-danger-main px-24 py-4 rounded-pill fw-medium text-sm">
                                        {{ $data['role'] }}
                                    </span>
                                @endif

                            </td>
                            <td>
                                {{-- <a href="javascript:void(0)"
                                    class="w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center">
                                    <iconify-icon icon="iconamoon:eye-light"></iconify-icon>
                                </a> --}}
                                <a href="{{ route('edit-users', ['id' => $data['id']]) }}"
                                    class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                    <iconify-icon icon="lucide:edit"></iconify-icon>
                                </a>
                                <a href="{{ route('delete-users', ['id' => $data['id']]) }}"
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
@endsection
