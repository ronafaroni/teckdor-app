@extends('template.admin')

@section('admin-content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Add Users</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="tdesign:user-add" class="icon text-lg"></iconify-icon>
                    Account
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Edit Users</li>
        </ul>
    </div>

    <div class="row gy-4">
        <div class="col-lg-12">
            <div class="card">
                {{-- <div class="card-header">
                    <h5 class="card-title mb-0">Input Custom Styles</h5>
                </div> --}}
                <div class="card-body">
                    <form action="{{ route('update-users', $user->id) }}" method="POST" class="row gy-3 needs-validation"
                        novalidate>
                        @csrf
                        <div class="col-md-12">
                            <label class="form-label">Name</label>
                            <input type="name" name="name" class="form-control @error('name') is-invalid @enderror"
                                placeholder="Enter Name" value="{{ $user->name }}">

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                placeholder="Enter Email" value="{{ $user->email }}">

                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Password</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror" placeholder="Enter Password">

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
                                    <!-- Admin -->
                                    <div class="form-check checked-danger d-flex align-items-center gap-2">
                                        <input class="form-check-input" type="radio" name="role" value="admin"
                                            id="horizontal1" {{ $user->role === 'admin' ? 'checked' : '' }}>
                                        <label class="form-check-label line-height-1 fw-medium text-secondary-light"
                                            for="horizontal1">
                                            Admin
                                        </label>
                                    </div>

                                    <!-- Customer -->
                                    <div class="form-check checked-danger d-flex align-items-center gap-2">
                                        <input class="form-check-input" type="radio" name="role" value="customer"
                                            id="horizontal2" {{ $user->role === 'customer' ? 'checked' : '' }}>
                                        <label class="form-check-label line-height-1 fw-medium text-secondary-light"
                                            for="horizontal2">
                                            Customer
                                        </label>
                                    </div>

                                    <!-- Finance -->
                                    <div class="form-check checked-danger d-flex align-items-center gap-2">
                                        <input class="form-check-input" type="radio" name="role" value="finance"
                                            id="horizontal3" {{ $user->role === 'finance' ? 'checked' : '' }}>
                                        <label class="form-check-label line-height-1 fw-medium text-secondary-light"
                                            for="horizontal3">
                                            Finance
                                        </label>
                                    </div>
                                </div>

                                @error('role')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <input type="hidden" value="{{ $user->id }}" name="id">

                        <div class="col-12">
                            <button type="submit" class="btn btn-danger radius-8 d-flex align-items-center gap-2"
                                onclick="return confirm('Are you sure?')">
                                <iconify-icon icon="ic:twotone-update" class="menu-icon text-lg"></iconify-icon>
                                <span>Update User</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
