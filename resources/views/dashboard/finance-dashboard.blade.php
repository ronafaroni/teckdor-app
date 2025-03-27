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
            <div class="card radius-8 border-0">
                <div class="row">
                    <div class="col-xxl-12">
                        <div class="row h-100 g-0">
                            <div class="col-3 p-0 m-0">
                                <div
                                    class="card-body p-24 h-100 d-flex flex-column justify-content-center border border-top-0">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                        <div>
                                            <span
                                                class="mb-12 w-44-px h-44-px text-primary-600 bg-primary-light border border-primary-light-white flex-shrink-0 d-flex justify-content-center align-items-center radius-8 h6 mb-12">
                                                <iconify-icon icon="fa-solid:box-open" class="icon"></iconify-icon>
                                            </span>
                                            <span class="mb-1 fw-medium text-secondary-light text-md">Total
                                                Payment</span>
                                            <h6 class="fw-semibold text-primary-light mb-1">
                                                {{ 'Rp. ' . number_format($total) }}
                                            </h6>
                                        </div>
                                    </div>
                                    {{-- <p class="text-sm mb-0">Increase by <span
                                            class="bg-success-focus px-1 rounded-2 fw-medium text-success-main text-sm">+200</span>
                                        this week</p> --}}
                                </div>
                            </div>
                            <div class="col-3 p-0 m-0">
                                <div
                                    class="card-body p-24 h-100 d-flex flex-column justify-content-center border border-top-0 border-start-0 border-end-0">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                        <div>
                                            <span
                                                class="mb-12 w-44-px h-44-px text-yellow bg-yellow-light border border-yellow-light-white flex-shrink-0 d-flex justify-content-center align-items-center radius-8 h6 mb-12">
                                                <iconify-icon icon="wpf:paid" class="icon"></iconify-icon>
                                            </span>
                                            <span class="mb-1 fw-medium text-secondary-light text-md">Paid
                                                Payment</span>
                                            <h6 class="fw-semibold text-primary-light mb-1">
                                                {{ 'Rp. ' . number_format($payment) }}
                                            </h6>
                                        </div>
                                    </div>
                                    {{-- <p class="text-sm mb-0">Increase by <span
                                            class="bg-danger-focus px-1 rounded-2 fw-medium text-danger-main text-sm">-5k</span>
                                        this week</p> --}}
                                </div>
                            </div>
                            <div class="col-3 p-0 m-0">
                                <div
                                    class="card-body p-24 h-100 d-flex flex-column justify-content-center border border-top-0 border-bottom-0">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                        <div>
                                            <span
                                                class="mb-12 w-44-px h-44-px text-primary-600 bg-primary-light border border-primary-light-white flex-shrink-0 d-flex justify-content-center align-items-center radius-8 h6">
                                                <iconify-icon icon="streamline:payment-cash-out-3"
                                                    class="icon"></iconify-icon>
                                            </span>
                                            <span class="mb-1 fw-medium text-secondary-light text-md">Unpaid
                                                Payment</span>
                                            <h6 class="fw-semibold text-primary-light mb-1">
                                                {{ 'Rp. ' . number_format($total - $payment) }}
                                            </h6>
                                        </div>
                                    </div>
                                    {{-- <p class="text-sm mb-0">Increase by <span
                                            class="bg-success-focus px-1 rounded-2 fw-medium text-success-main text-sm">+1k</span>
                                        this week</p> --}}
                                </div>
                            </div>
                            <div class="col-3 p-0 m-0">
                                <div
                                    class="card-body p-24 h-100 d-flex flex-column justify-content-center border border-top-0 border-start-0 border-end-0 border-bottom-0">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">
                                        <div>
                                            <span
                                                class="mb-12 w-44-px h-44-px text-pink bg-pink-light border border-pink-light-white flex-shrink-0 d-flex justify-content-center align-items-center radius-8 h6 mb-12">
                                                <iconify-icon icon="ri:discount-percent-fill" class="icon"></iconify-icon>
                                            </span>
                                            <span class="mb-1 fw-medium text-secondary-light text-md">Supplier
                                                Payment</span>
                                            <h6 class="fw-semibold text-primary-light mb-1">
                                                {{ 'Rp. ' . number_format($supplierPayment) }}
                                            </h6>
                                        </div>
                                    </div>
                                    {{-- <p class="text-sm mb-0">Increase by <span
                                            class="bg-success-focus px-1 rounded-2 fw-medium text-success-main text-sm">+$10k</span>
                                        this week</p> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
