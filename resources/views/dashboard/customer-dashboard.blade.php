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
                        <div class="table-responsive scroll-sm">
                            <form action="{{ route('store-selected-products') }}" method="POST">
                                @csrf

                                <table class="table bordered-table mb-0" data-page-length='10'>
                                    <thead>
                                        <tr>
                                            <th scope="col"><input type="checkbox" id="select-all"></th>
                                            {{-- checkbox untuk pilih semua --}}
                                            <th scope="col">Code</th>
                                            <th scope="col">Product</th>
                                            <th scope="col">Category</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Stocks</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody align="center">
                                        @foreach ($product as $data)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="form-check-input product-checkbox"
                                                        name="selected_products[]" value="{{ $data->id }}">
                                                </td>
                                                <td>{{ $data->code_product }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ asset('storage/' . $data->thumbnail) }}" alt=""
                                                            class="flex-shrink-0 me-12 radius-8"
                                                            style="width: 40px; height: 40px; object-fit: cover;">
                                                        <h6 class="text-md mb-0 fw-medium flex-grow-1">
                                                            {{ $data->name_product }}</h6>
                                                    </div>
                                                </td>
                                                <td>{{ $data->category->name_category }}</td>
                                                <td>{{ 'Rp. ' . number_format($data->price) }}</td>
                                                <td>
                                                    {{ ($data->product_stocks_sum_stock ?? 0) + ($data->stock ?? 0) + ($data->orders_sum_qty ?? 0) }}
                                                    Set
                                                </td>
                                                <td>
                                                    <a href="{{ route('show-product', $data->id) }}"
                                                        class="btn btn-danger radius-8 d-flex align-items-center justify-content-center gap-2">
                                                        <iconify-icon icon="lucide:edit"
                                                            class="menu-icon text-lg"></iconify-icon>
                                                        <span>Order Now</span>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <button type="submit"
                                    class="btn btn-dark radius-8 d-flex align-items-center justify-content-center gap-2">
                                    <iconify-icon icon="lets-icons:check-fill" class="menu-icon text-lg"></iconify-icon>
                                    <span>Cart Now</span>
                                </button>
                            </form>
                        </div>
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
                                <div class="table-responsive scroll-sm">
                                    <form action="{{ route('store-selected-products') }}" method="POST">
                                        @csrf
                                        <table class="table bordered-table mb-0" data-page-length='10'>
                                            <thead>
                                                <tr>
                                                    <th scope="col"><input type="checkbox" id="select-all"></th>
                                                    {{-- checkbox untuk pilih semua --}}
                                                    <th scope="col">Code</th>
                                                    <th scope="col">Product</th>
                                                    <th scope="col">Category</th>
                                                    <th scope="col">Price</th>
                                                    <th scope="col">Stocks</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody align="center">
                                                @foreach ($product as $data)
                                                    <tr>
                                                        <td>
                                                            <input class="class="form-check-input product-checkbox""
                                                                type="checkbox" name="selected_products[]"
                                                                value="{{ $data->id }}">
                                                        </td>
                                                        <td>{{ $data->code_product }}</td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <img src="{{ asset('storage/' . $data->thumbnail) }}"
                                                                    alt="" class="flex-shrink-0 me-12 radius-8"
                                                                    style="width: 40px; height: 40px; object-fit: cover;">
                                                                <h6 class="text-md mb-0 fw-medium flex-grow-1">
                                                                    {{ $data->name_product }}</h6>
                                                            </div>
                                                        </td>
                                                        <td>{{ $data->category->name_category }}</td>
                                                        <td>{{ 'Rp. ' . number_format($data->price) }}</td>
                                                        <td>
                                                            {{ ($data->product_stocks_sum_stock ?? 0) + ($data->stock ?? 0) + ($data->orders_sum_qty ?? 0) }}
                                                            Set
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('show-product', $data->id) }}"
                                                                class="btn btn-danger radius-8 d-flex align-items-center justify-content-center gap-2">
                                                                <iconify-icon icon="lucide:edit"
                                                                    class="menu-icon text-lg"></iconify-icon>
                                                                <span>Order Now</span>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <button type="submit"
                                            class="btn btn-dark radius-8 d-flex align-items-center justify-content-center gap-2">
                                            <iconify-icon icon="lets-icons:check-fill"
                                                class="menu-icon text-lg"></iconify-icon>
                                            <span>Cart Now</span>
                                        </button>
                                    </form>

                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach

            </div>
        </div>
    </div>

    <script>
        document.getElementById('select-all').addEventListener('click', function(event) {
            const checkboxes = document.querySelectorAll('input[name="selected_products[]"]');
            checkboxes.forEach(cb => cb.checked = event.target.checked);
        });
    </script>


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
