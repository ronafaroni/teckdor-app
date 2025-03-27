@extends('template.admin')

@section('admin-content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Add New Users</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="tdesign:user-add" class="icon text-lg"></iconify-icon>
                    Account
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Add Users</li>
        </ul>
    </div>

    <div class="row gy-4">
        <div class="col-lg-12">
            <div class="card">
                {{-- <div class="card-header">
                    <h5 class="card-title mb-0">Input Custom Styles</h5>
                </div> --}}
                <div class="card-body">
                    <form action="{{ route('save-users') }}" method="POST" class="row gy-3 needs-validation" novalidate>
                        @csrf
                        <div class="col-md-12">
                            <label class="form-label">Name</label>
                            <input type="name" name="name" class="form-control @error('name') is-invalid @enderror"
                                placeholder="Enter Name" value="{{ old('name') }}">

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                placeholder="Enter Email" value="{{ old('email') }}">

                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Password</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror" placeholder="Enter Password"
                                value="{{ old('password') }}">

                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <div class="icon-field has-validation">
                                <label class="form-label">Role Action</label>
                                <div class="d-flex align-items-center flex-wrap gap-28">
                                    <div class="form-check checked-danger d-flex align-items-center gap-2">
                                        <input class="form-check-input" type="radio" name="role" value="admin"
                                            id="horizontal1" checked>
                                        <label class="form-check-label line-height-1 fw-medium text-secondary-light"
                                            for="horizontal1"> Admin </label>
                                    </div>
                                    <div class="form-check checked-danger d-flex align-items-center gap-2">
                                        <input class="form-check-input" type="radio" name="role" value="customer"
                                            id="horizontal2">
                                        <label class="form-check-label line-height-1 fw-medium text-secondary-light"
                                            for="horizontal2"> Customer </label>
                                    </div>
                                    <div class="form-check checked-danger d-flex align-items-center gap-2">
                                        <input class="form-check-input" type="radio" name="role" value="finance"
                                            id="horizontal2">
                                        <label class="form-check-label line-height-1 fw-medium text-secondary-light"
                                            for="horizontal2"> Finance </label>
                                    </div>
                                </div>

                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-danger radius-8 d-flex align-items-center gap-2">
                                <iconify-icon icon="tdesign:user-add" class="menu-icon text-lg"></iconify-icon>
                                <span>Add User</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
