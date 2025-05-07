@extends('template.customer')

@section('customer-content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Orders</h6>
        <ul class="d-flex align-items-center gap-2">

        </ul>
    </div>

    <div class="card basic-data-table">
        <div class="card-body">

            <div class="table-responsive scroll-sm">
                <table class="table bordered-table mb-0" data-page-length='10'>
                    <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Code</th>
                            <th scope="col">Product</th>
                            <th scope="col">Order</th>
                            <th scope="col">Price</th>
                            <th scope="col">Total Payment</th>
                            <th scope="col">Status Payment</th>
                            <th scope="col">Status Order</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody align="center">
                        @foreach ($order_list as $itemOrder)
                            <tr>
                                <td></td>
                                <td>{{ $itemOrder->code_order }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('storage/' . $itemOrder->product->thumbnail) }}" alt=""
                                            class="flex-shrink-0 me-12 radius-8"
                                            style="width: 40px; height: 40px; object-fit: cover; border-radius: 8px;">
                                        <h6 class="text-md mb-0 fw-medium flex-grow-1">
                                            {{ $itemOrder->product->name_product }}</h6>
                                    </div>
                                </td>

                                <td>{{ $itemOrder->qty }} Set</td>
                                <td>Rp. {{ number_format($itemOrder->total_payment) }}</td>
                                <td>Rp. {{ number_format($itemOrder->total_payment * $itemOrder->qty) }}</td>
                                <td>
                                    @if ($itemOrder->payment_status == 'Paid')
                                        <span class="fw-medium">
                                            <span
                                                class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">
                                                Paid Payment
                                            </span>
                                        </span>
                                    @else
                                        <span class="fw-medium">
                                            <span
                                                class="bg-danger-focus text-danger-main px-24 py-4 rounded-pill fw-medium text-sm">
                                                Unpaid Payment
                                            </span>
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="fw-medium">
                                        <button type="button"
                                            class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm"
                                            data-bs-toggle="modal" data-bs-target="#orderModal{{ $itemOrder->code_order }}">
                                            <!-- Sesuaikan dengan ID modal -->
                                            {{ $itemOrder->orderProgress->first()->name_progress ?? 'No Progress' }}
                                        </button>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex flex-column align-items-end justify-content-between">
                                        <div class="d-flex justify-content-between gap-1 w-100">
                                            <!-- Tombol Order Detail selalu ditampilkan -->
                                            <button type="button"
                                                class="btn btn-dark btn-md radius-8 d-flex align-items-center justify-content-center gap-2 order-now-btn"
                                                data-bs-toggle="modal" data-bs-target="#productModal{{ $itemOrder->id }}">
                                                <iconify-icon icon="icon-park-outline:view-grid-detail"
                                                    class="menu-icon text-lg"></iconify-icon>
                                                <span>Order Detail</span>
                                            </button>

                                            <!-- Tombol Cancel hanya muncul jika status masih belum approved atau finished -->
                                            @if (!in_array($itemOrder->status, ['approved', 'finished']))
                                                <a href="{{ route('delete-order', $itemOrder->id) }}"
                                                    class="btn btn-danger btn-md radius-8 d-flex align-items-center justify-content-center gap-2"
                                                    onclick="return confirm('Are you sure want to delete product order ?')">
                                                    <iconify-icon icon="material-symbols:cancel-outline-rounded"
                                                        class="menu-icon text-lg"></iconify-icon>
                                                    <span>Cancel</span>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @foreach ($order_list as $itemOrder)
        <!-- Modal Detail Product -->
        <div class="modal fade" id="productModal{{ $itemOrder->id }}" tabindex="-1" aria-labelledby="productModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="productModalLabel">Order Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <form action="{{ route('save-product') }}" method="POST" class="row gy-3 needs-validation"
                                enctype="multipart/form-data" novalidate>
                                @csrf

                                <div class="col-md-12">
                                    <label class="form-label">Product Sample</label>
                                    <div class="upload-image-wrapper d-flex align-items-center gap-3 w-100">
                                        <div
                                            class="uploaded-img position-relative w-100 h-100 border input-form-light radius-8 overflow-hidden border-dashed bg-neutral-50">
                                            <!-- Menampilkan gambar dari database -->
                                            @if ($itemOrder->img_sample && Storage::disk('public')->exists($itemOrder->img_sample))
                                                <img class="uploaded-img__preview w-100 h-100 object-fit-contain border rounded"
                                                    src="{{ asset('storage/' . $itemOrder->img_sample) }}"
                                                    alt="Image Sample">
                                            @else
                                                <div
                                                    class="d-flex align-items-center justify-content-center h-100 bg-light border rounded">
                                                    <p class="text-muted text-center mb-0">No image uploaded</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    @error('thumbnail')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Name Product</label>
                                    <input type="name" name="product_name"
                                        class="form-control @error('product_name') is-invalid @enderror"
                                        placeholder="Enter Product Name" value="{{ $itemOrder->product->name_product }}"
                                        readonly>

                                    @error('product_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Description</label>
                                    <textarea rows="10" type="text" name="description"
                                        class="form-control @error('description') is-invalid @enderror" placeholder="Enter Product Description"
                                        value="{{ old('description') }}" readonly>{{ $itemOrder->description }}</textarea>

                                    @error('description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Quantity</label>
                                    <input type="number" name="stock"
                                        class="form-control @error('stock') is-invalid @enderror" placeholder="Enter Stock"
                                        value="{{ number_format($itemOrder->qty) }}" readonly>

                                    @error('stock')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Length (Cm)</label>
                                    <input type="number" name="length"
                                        class="form-control @error('length') is-invalid @enderror"
                                        placeholder="Enter Length" value="{{ number_format($itemOrder->length) }}"
                                        readonly>

                                    @error('length')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Width (Cm)</label>
                                    <input type="number" name="width"
                                        class="form-control @error('width') is-invalid @enderror"
                                        placeholder="Enter Width" value="{{ number_format($itemOrder->width) }}"
                                        readonly>

                                    @error('width')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Height (Cm)</label>
                                    <input type="number" name="height"
                                        class="form-control @error('height') is-invalid @enderror"
                                        placeholder="Enter Height" value="{{ number_format($itemOrder->height) }}"
                                        readonly>

                                    @error('height')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($order_confirm as $itemOrder)
        <!-- Modal Detail Product -->
        <div class="modal fade" id="productModal{{ $itemOrder->id }}" tabindex="-1"
            aria-labelledby="productModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="productModalLabel">Order Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <form action="{{ route('save-product') }}" method="POST" class="row gy-3 needs-validation"
                                enctype="multipart/form-data" novalidate>
                                @csrf

                                <div class="col-md-12">
                                    <label class="form-label">Product Sample</label>
                                    <div class="upload-image-wrapper d-flex align-items-center gap-3 w-100">
                                        <div
                                            class="uploaded-img position-relative w-100 h-100 border input-form-light radius-8 overflow-hidden border-dashed bg-neutral-50">
                                            <!-- Menampilkan gambar dari database -->
                                            <img class="uploaded-img__preview w-100 h-100 object-fit-contain"
                                                src="{{ asset('storage/' . $itemOrder->img_sample) }}"
                                                alt="Image Sample">
                                        </div>
                                    </div>

                                    @error('thumbnail')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Name Product</label>
                                    <input type="name" name="product_name"
                                        class="form-control @error('product_name') is-invalid @enderror"
                                        placeholder="Enter Product Name" value="{{ $itemOrder->product->name_product }}"
                                        readonly>

                                    @error('product_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label">Description</label>
                                    <textarea rows="10" type="text" name="description"
                                        class="form-control @error('description') is-invalid @enderror" placeholder="Enter Product Description"
                                        value="{{ old('description') }}" readonly>{{ $itemOrder->description }}</textarea>

                                    @error('description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Quantity</label>
                                    <input type="number" name="stock"
                                        class="form-control @error('stock') is-invalid @enderror"
                                        placeholder="Enter Stock" value="{{ number_format($itemOrder->qty) }}" readonly>

                                    @error('stock')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Length (Cm)</label>
                                    <input type="number" name="length"
                                        class="form-control @error('length') is-invalid @enderror"
                                        placeholder="Enter Length" value="{{ number_format($itemOrder->length) }}"
                                        readonly>

                                    @error('length')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Width (Cm)</label>
                                    <input type="number" name="width"
                                        class="form-control @error('width') is-invalid @enderror"
                                        placeholder="Enter Width" value="{{ number_format($itemOrder->width) }}"
                                        readonly>

                                    @error('width')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Height (Cm)</label>
                                    <input type="number" name="height"
                                        class="form-control @error('height') is-invalid @enderror"
                                        placeholder="Enter Height" value="{{ number_format($itemOrder->height) }}"
                                        readonly>

                                    @error('height')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($order_progress_list as $orderItem)
        <div class="modal fade modal-lg" id="orderModal{{ $orderItem->code_order }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Status History</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($order_progress_list as $progress)
                                    @if ($progress->code_order == $orderItem->code_order)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $progress->name_progress }}</td>
                                            <td>{{ $progress->created_at->format('d F Y H:i:s') }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
