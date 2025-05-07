@extends('template.finance')

@section('finance-content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Dashboard</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
        </ul>
    </div>

    <div class="row gy-4">
        <div class="col-xxl-12">
            <p>Selamat Datang, di Aplikasi TeckD'or Indonesia.</p>
        </div>
    </div>
@endsection
