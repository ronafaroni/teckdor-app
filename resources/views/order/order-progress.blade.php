@extends('template.admin')

@section('admin-content')
    <div class="container">
        <!-- Header Section -->
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Order Progress</h6>
        </div>

        <!-- Card Section -->
        <div class="card flex-grow-1">
            <div class="card-body">
                <!-- Alert Messages -->
                @foreach (['updated' => 'warning', 'deleted' => 'danger', 'success' => 'success'] as $key => $type)
                    @if (session()->has($key))
                        <div class="alert alert-{{ $type }} d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <iconify-icon icon="mdi:alert-circle-outline" class="icon text-xl"></iconify-icon>
                                <span>{{ session()->get($key) }}</span>
                            </div>
                            <button class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                @endforeach

                <!-- Orders Table -->
                <div class="table-responsive scroll-sm">
                    <table class="table bordered-table mb-0">
                        <thead>
                            <tr>
                                <th>Order Product</th>
                                <th>Total Payment</th>
                                <th>Progress Update</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($paginatedOrders as $supplierName => $orderGroup)
                                <tr class="table-secondary">
                                    <td colspan="3"><strong>Supplier: {{ $supplierName }}</strong></td>
                                </tr>
                                @foreach ($orderGroup as $order)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('storage/' . $order->product->thumbnail) }}"
                                                    alt="Product Image" class="me-3 rounded-3"
                                                    style="width: 120px; height: 90px; object-fit: cover;">
                                                <div>
                                                    <span class="text-muted text-sm">Customer:
                                                        {{ $order->user->name }}</span>
                                                    <h6 class="fw-medium mb-1">{{ $order->product->name_product }}</h6>
                                                    <span class="text-muted text-sm">
                                                        Order : {{ $order->qty }} Set | Date :
                                                        {{ $order->created_at->format('d F Y') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <h6>{{ number_format($order->qty * $order->total_payment) }}</h6>
                                        </td>
                                        <td>
                                            <span class="fw-medium">
                                                <button type="button"
                                                    class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#orderModal{{ $order->code_order }}">
                                                    <!-- Sesuaikan dengan ID modal -->
                                                    {{ $order->orderProgress->first()->name_progress ?? 'No Progress' }}
                                                </button>
                                            </span>
                                        </td>
                                        <td>
                                            <!-- Tombol Order Now -->
                                            @php
                                                $order_status = $order->orderProgress->first()->status ?? 'No Progress';
                                            @endphp
                                            @if ($order_status == 'finish')
                                                <button type="button"
                                                    class="btn btn-danger btn-md radius-8 d-flex align-items-center justify-content-center gap-2 order-now-btn"
                                                    data-bs-toggle="modal" data-bs-target="#orderModal{{ $order->id }}">
                                                    <iconify-icon icon="icon-park-outline:view-grid-detail"
                                                        class="menu-icon text-lg"></iconify-icon>
                                                    <span>Progress Finish</span>
                                                </button>
                                            @else
                                                <button type="button"
                                                    class="btn btn-dark btn-md radius-8 d-flex align-items-center justify-content-center gap-2 order-now-btn"
                                                    data-bs-toggle="modal" data-bs-target="#orderModal{{ $order->id }}">
                                                    <iconify-icon icon="icon-park-outline:view-grid-detail"
                                                        class="menu-icon text-lg"></iconify-icon>
                                                    <span>Progress Update</span>
                                                </button>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">
                                        <strong>No Orders Available</strong>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="card-body p-24">
                    <ul class="pagination d-flex flex-wrap align-items-center gap-2 justify-content-center mt-24">
                        {{-- Previous Page Link --}}
                        @if ($paginatedOrders->onFirstPage())
                            <li class="page-item disabled">
                                <span
                                    class="page-link bg-danger-50 text-danger fw-medium radius-8 border-0 px-20 py-10 d-flex align-items-center justify-content-center h-48-px">Previous</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link bg-danger-50 text-danger fw-medium radius-8 border-0 px-20 py-10 d-flex align-items-center justify-content-center h-48-px"
                                    href="{{ $paginatedOrders->previousPageUrl() }}">Previous</a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($paginatedOrders->getUrlRange(1, $paginatedOrders->lastPage()) as $page => $url)
                            <li class="page-item {{ $page == $paginatedOrders->currentPage() ? 'active' : '' }}">
                                <a class="page-link bg-danger-50 text-danger fw-medium radius-8 border-0 px-20 py-10 d-flex align-items-center justify-content-center h-48-px w-48-px {{ $page == $paginatedOrders->currentPage() ? 'bg-danger-600 text-white' : '' }}"
                                    href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($paginatedOrders->hasMorePages())
                            <li class="page-item">
                                <a class="page-link bg-danger-50 text-danger fw-medium radius-8 border-0 px-20 py-10 d-flex align-items-center justify-content-center h-48-px"
                                    href="{{ $paginatedOrders->nextPageUrl() }}">Next</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span
                                    class="page-link bg-danger-50 text-danger fw-medium radius-8 border-0 px-20 py-10 d-flex align-items-center justify-content-center h-48-px">Next</span>
                            </li>
                        @endif
                    </ul>
                </div>

            </div>
        </div>

        <!-- Modal Section -->
        @foreach ($paginatedOrders as $orderGroup)
            @foreach ($orderGroup as $order)
                <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Progress Updated</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form method="POST" action="{{ route('order-progress-update') }}">
                                @csrf
                                <div class="modal-body">
                                    <label class="form-label">Progress Status</label>
                                    <select name="progress_name" class="form-select">
                                        <option value="" disabled selected>Select Progress</option>
                                        @foreach ($order_progress as $progress)
                                            <option value="{{ $progress->name_progress }}">{{ $progress->name_progress }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="modal-body">
                                    <label class="form-label">Finishing Type</label>
                                    <select name="finishing_name" class="form-select">
                                        <option value="" disabled selected>Select Type</option>
                                        @foreach ($finishing as $item)
                                            <option value="{{ $item->name }}">{{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="modal-body">
                                    <div class="d-flex align-items-center flex-wrap gap-2">
                                        <label for="switch1">Order Status : </label>
                                        <div class="form-switch switch-primary d-flex align-items-center gap-3">
                                            <input class="form-check-input" name="status" type="checkbox" role="finish"
                                                id="switch1" value="finish">
                                            <label class="form-check-label line-height-1 fw-medium text-secondary-light"
                                                for="switch1">Finished</label>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="order_id" value="{{ $order->id }}" hidden">
                                <input type="hidden" name="code_order" value="{{ $order->code_order }}" hidden>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-danger">Update Progress</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach

        <!-- Modal Section -->
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
                                        <th scope="col">Finishing</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp
                                    @foreach ($order_progress_list as $progress)
                                        @if ($progress->code_order == $orderItem->code_order)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $progress->name_progress }}</td>
                                                <td>{{ $progress->finishing }}</td>
                                                <td>{{ $progress->created_at->format('d F Y H:i:s') }}</td>
                                                <td>
                                                    <form action="{{ route('order-progress-delete', $progress->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this progress?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-md">
                                                            <iconify-icon icon="mingcute:delete-2-line">
                                                            </iconify-icon>
                                                        </button>
                                                    </form>
                                                </td>
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

    </div>

    <script>
        document.getElementById('switch1').addEventListener('change', function() {
            const statusInput = document.getElementById('status');
            if (this.checked) {
                statusInput.value = 'finish'; // Jika checkbox dicentang
            } else {
                statusInput.value = 'progress'; // Jika checkbox tidak dicentang
            }
        });
    </script>
@endsection
