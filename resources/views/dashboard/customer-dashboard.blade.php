@extends('template.customer')

@section('customer-content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Welcome {{ Auth::user()->name }}.</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Home
                </a>
            </li>
        </ul>
    </div>

    <div class="card h-100 p-0 radius-12 overflow-hidden">
        <div class="card-body p-24">
            <div class="col-md-4 py-10 d-flex align-items-center gap-3">
                <select id="supplierDropdown" class="form-select">
                    <option value="all" selected>All Products</option>
                    @foreach ($category as $item)
                        <option value="{{ $item->id }}">{{ $item->name_category }}</option>
                    @endforeach
                </select>
            </div>

            <div class="tab-content" id="pills-tabContent">

                {{-- Untuk menampilkan All Product --}}
                <div id="allProducts" class="tab-pane fade show active" role="tabpanel" aria-labelledby="pills-all-tab"
                    tabindex="0">
                    <div class="row gy-4">
                        @foreach ($product as $itemProduct)
                            <a href="{{ route('show-product', $itemProduct->id) }}" class="col-xxl-4 col-md-4 col-sm-6">
                                <div class="hover-scale-img border radius-16 overflow-hidden">
                                    <div class="position-relative overflow-hidden" style="height: 266px; width: 100%;">
                                        <img src="{{ asset('storage/' . $itemProduct->thumbnail) }}" alt=""
                                            class="hover-scale-img__img w-100 h-100 object-fit-cover"
                                            style="height: 100%; width: 100%; object-fit: cover; object-position: center;">
                                        <button type="button"
                                            class="btn rounded-pill btn-sm btn-danger-100 text-danger-600 radius-8 px-3 py-1 position-absolute end-0 bottom-0 m-2">
                                            {{ $itemProduct->category->name_category }}
                                        </button>
                                    </div>
                                    <div class="py-16 px-24">
                                        <p class="mb-4"><b>{{ $itemProduct->name_product }}</b></p>
                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-between">
                                                <p class="mb-0 text-sm">
                                                    Stock :
                                                    {{ ($itemProduct->product_stocks_sum_stock ?? 0) + ($itemProduct->stock ?? 0) + ($itemProduct->orders_sum_qty ?? 0) }}
                                                    Set
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Untuk menampilkan Product berdasarkan kategori --}}
                @foreach ($category as $itemCategory)
                    <div id="category{{ $itemCategory->id }}" class="tab-pane" role="tabpanel"
                        aria-labelledby="pills-{{ $itemCategory->id }}-tab" tabindex="0">
                        @if ($itemCategory->products->isEmpty())
                            <div class="d-flex justify-content-center align-items-center" style="height: 60vh;">
                                <p>No products available.</p>
                            </div>
                        @else
                            <div class="row gy-4">
                                @foreach ($itemCategory->products as $data)
                                    <a href="{{ route('show-product', $data->id) }}" class="col-xxl-4 col-md-4 col-sm-6">
                                        <div class="hover-scale-img border radius-16 overflow-hidden">
                                            <div class="position-relative overflow-hidden"
                                                style="height: 266px; width: 100%;">
                                                <img src="{{ asset('storage/' . $data->thumbnail) }}" alt=""
                                                    class="hover-scale-img__img w-100 h-100 object-fit-cover"
                                                    style="height: 100%; width: 100%; object-fit: cover; object-position: center;">
                                                <button type="button"
                                                    class="btn rounded-pill btn-sm btn-danger-100 text-danger-600 radius-8 px-3 py-1 position-absolute end-0 bottom-0 m-2">
                                                    {{ $data->category->name_category }}
                                                </button>
                                            </div>
                                            <div class="py-16 px-24">
                                                <p class="mb-4"><b>{{ $data->name_product }}</b></p>
                                                <div class="row">
                                                    <div class="col-12 d-flex justify-content-between">
                                                        <p class="mb-0 text-sm">Stock : {{ $data->stock }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropdown = document.getElementById('supplierDropdown');
            const allProducts = document.getElementById('allProducts');
            const categoryTabs = document.querySelectorAll('[id^="category"]');

            dropdown.addEventListener('change', function() {
                const selectedValue = this.value;

                // Sembunyikan semua tab
                allProducts.style.display = 'none';
                categoryTabs.forEach(tab => {
                    tab.style.display = 'none';
                });

                // Tampilkan tab yang dipilih
                if (selectedValue === 'all') {
                    allProducts.style.display = 'block';
                } else {
                    const selectedTab = document.getElementById(`category${selectedValue}`);
                    if (selectedTab) {
                        selectedTab.style.display = 'block';
                    }
                }
            });

            // Set default to "All Products"
            allProducts.style.display = 'block';
        });
    </script>
@endsection
