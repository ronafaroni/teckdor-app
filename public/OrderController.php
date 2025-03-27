<?php

namespace App\Http\Controllers;

use App\Models\OrderProgress;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Order;
use App\Models\OrderProgressSetting;
use App\Models\OrderShipping;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function dataOrder()
    {
        $customerId = Auth::user()->id;
        $order_submit = Order::with('product', 'user')
            ->where('user_id', $customerId)
            ->where('is_draft', 'false')
            ->where('status', 'submission')
            ->orderBy('order_date', 'desc')
            ->get();

        $order_confirm = Order::with('product', 'user')
            ->where('user_id', $customerId)
            ->where('is_draft', 'false')
            ->where('status', 'approved')
            ->where('payment_status', '=', null)
            ->orderBy('order_date', 'desc')
            ->get();

        $order_progress = Order::with([
            'product',
            'user',
            'orderProgress' => function ($query) {
                $query->latest()->limit(1);
                $query->where('status', 'progress'); // Ambil progress terbaru
            }
        ])
            ->where('user_id', $customerId)
            ->where('is_draft', 'false')
            ->where('status', 'approved')
            ->whereNotNull('payment_status')
            ->whereHas('orderProgress', function ($query) {
                $query->where('status', 'progress');
                $query->orderBy('order_date', 'desc');
            })
            ->whereDoesntHave('orderProgress', function ($query) {
                $query->where('status', 'finish'); // Mengecualikan order_id yang sudah "finish"
            })
            ->orderBy('order_date', 'desc')
            ->get();

        $order_progress_list = OrderProgress::all();

        $order_done = Order::with([
            'product',
            'user',
            'orderProgress' => function ($query) {
                $query->latest()->limit(1); // Ambil progress terbaru
            }
        ])
            ->where('user_id', $customerId)
            ->where('is_draft', 'false')
            ->where('status', 'approved')
            ->where('payment_status', '!=', null)
            ->whereHas('orderProgress', function ($query) {
                $query->where('status', 'finish'); // Filter berdasarkan status di orderProgress
            })
            ->orderBy('order_date', 'desc')
            ->get();

        $order_shipping = OrderShipping::with('order.product', 'order.user')->get();


        $order_status = Order::with('product', 'user')
            ->where('user_id', $customerId)
            ->where('is_draft', 'false')
            ->where('status', 'submission')
            ->orderBy('order_date', 'desc')
            ->get();

        return view('order.data-order', compact(
            'order_submit',
            'order_confirm',
            'order_progress',
            'order_progress_list',
            'order_status',
            'order_done',
            'order_shipping'
        ));
    }

    public function editCart($id)
    {
        $order = Order::with('product')->find($id);
        $category = Category::all();
        $supplier = Supplier::all();
        return view('cart.edit-cart', compact('order'));
    }

    public function saveCart(Request $request, $id)
    {
        $request->validate([
            'qty' => 'required',
            'desc_order' => 'nullable',
            'length' => 'nullable',
            'width' => 'nullable',
            'height' => 'nullable',
            'image_sample' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $order = Order::find($id);
        $order->qty = $request->qty;
        $order->description = $request->desc_order;
        $order->length = $request->length;
        $order->width = $request->width;
        $order->height = $request->height;

        if ($request->hasFile('image_sample')) {
            $thumbnailPath = $request->file('image_sample')->store('image_sample', 'public');
            $order->img_sample = $thumbnailPath;
        }

        $order->save();
        return redirect()->route('data-cart')->with('success', 'Cart updated successfully.');
    }

    public function orderList()
    {
        $orders = Order::with('product.supplier', 'user')
            ->where('is_draft', 'false')
            ->where('status', 'submission')
            ->orderBy('updated_at', 'desc')
            ->get()
            ->groupBy('product.supplier.name_supplier'); // Mengelompokkan berdasarkan nama supplier

        return view('order.order-list', compact('orders'));
    }

    public function orderPayment()
    {
        $orders = Order::with('product.supplier', 'user')
            ->where('is_draft', 'false')
            ->where('status', 'approved')
            ->where('payment_status', '=', null)
            ->orderBy('updated_at', 'desc')
            ->get()
            ->groupBy('product.supplier.name_supplier'); // Mengelompokkan berdasarkan nama supplier

        return view('order.order-payment', compact('orders'));
    }

    public function orderProgress()
    {
        $orders = Order::with([
            'product.supplier',
            'user',
            'orderProgress' => function ($query) {
                $query->latest()->limit(1);
            }
        ])
            ->where('is_draft', 'false')
            ->where('status', 'approved')
            ->where('payment_status', '!=', null)
            ->orderBy('updated_at', 'desc')
            ->get()
            ->groupBy('product.supplier.name_supplier');

        $order_progress = OrderProgressSetting::all();

        $order_progress_list = OrderProgress::all();

        return view('order.order-progress', compact(
            'orders',
            'order_progress',
            'order_progress_list'
        ));
    }

    public function orderShipping()
    {
        $orders = Order::with([
            'product.supplier',
            'user',
            'orderProgress' => function ($query) {
                $query->where('status', 'finish') // Hanya ambil orderProgress dengan status 'finish'
                    ->latest() // Ambil yang terbaru
                    ->limit(1); // Batasi hanya 1 data terbaru
            }
        ])
            ->where('is_draft', 'false')
            ->where('status', 'approved')
            ->where('payment_status', '!=', null)
            ->whereHas('orderProgress', function ($query) {
                $query->where('status', 'finish'); // Hanya ambil order yang memiliki orderProgress dengan status 'finish'
            })
            ->orderBy('updated_at', 'desc')
            ->get()
            ->groupBy('product.supplier.name_supplier');

        $order_progress = OrderProgressSetting::all();

        $order_progress_list = OrderProgress::with('order')
            ->where('status', 'finish')
            ->whereNotIn('order_id', function ($query) {
                $query->select('order_id')->from('order_shippings');
            })
            ->get();


        $order_shipping_list = OrderShipping::selectRaw('code_shipping, COUNT(order_id) as total_products, MIN(created_at) as created_at')
            ->groupBy('code_shipping')
            ->get();

        return view('order.order-shipping', compact('orders', 'order_progress', 'order_progress_list', 'order_shipping_list'));
    }

    public function orderLog()
    {
        $orders = Order::with('product.supplier', 'user')
            ->where('is_draft', 'false')
            ->orderBy('updated_at', 'asc')
            ->get()
            ->groupBy('code_order');

        return view('order.order-log', compact('orders'));
    }

    public function orderDetail($code_order)
    {
        $order = Order::with('product.supplier', 'user', 'orderProgress')
            ->where('code_order', $code_order)
            ->first();

        $detail_order = Order::with('product.supplier', 'user', 'orderProgress')
            ->where('code_order', $code_order)
            ->get();
        $order_progress = OrderProgressSetting::all();
        return view('order.order-detail', compact('order', 'order_progress', 'detail_order'));
    }

    public function showProduct($id)
    {
        $product = Product::with('images', 'category', 'supplier')
            ->withSum('productStocks', 'stock') // Total stok dari productStocks
            ->withSum([
                'orders' => function ($query) {
                    $query->where('status', 'approved'); // Hanya hitung qty dari order yang berstatus approved
                }
            ], 'qty') // Total qty dari orders yang approved
            ->find($id);

        $category = Category::all();
        $supplier = Supplier::all();
        return view('customer.pesanan', compact('product', 'supplier', 'category'));
    }

    public function orderProduct(Request $request)
    {
        $request->validate([
            'qty' => 'required',
            'desc_order' => 'nullable',
            'length' => 'nullable',
            'width' => 'nullable',
            'height' => 'nullable',
            'image_sample' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $order = new Order;
        $order->product_id = $request->product_id;
        $order->user_id = $request->customer_id;
        $order->qty = $request->qty;
        $order->description = $request->desc_order;
        $order->length = $request->length;
        $order->width = $request->width;
        $order->height = $request->height;

        // Simpan gambar thumbnail produk
        // $thumbnailPath = $request->file('image_sample')->store('image_sample', 'public');
        // $order->img_sample = $thumbnailPath;

        if ($request->hasFile('image_sample')) {
            $thumbnailPath = $request->file('image_sample')->store('image_sample', 'public');
            $order->img_sample = $thumbnailPath;
        }

        $order->is_draft = $request->is_draft;

        if ($order->is_draft == 'false') {
            $order->status = 'submission';
            $order->code_order = 'SN.' . mt_rand(1000, 9999) . '.' . strtoupper(Str::random(4));
        }

        $order->save();

        switch ($order->is_draft) {
            case 'true':
                return redirect()->route('data-cart')->with('success', 'Product to cart successfully');
            default:
                return redirect()->route('data-order')->with('success', 'Product order successfully');
        }
    }

    public function dataCart()
    {
        $customerId = Auth::user()->id;
        $value = 'true';

        $data_cart = Order::with('product')
            ->where('user_id', $customerId)
            ->where('is_draft', $value)
            ->get();

        return view('cart.data-cart', compact('data_cart'));
    }

    public function update(Request $request)
    {
        // Validasi data
        $request->validate([
            'product_ids' => 'required|array', // Pastikan ada produk yang dipilih
            'product_ids.*' => 'exists:orders,id', // Pastikan ID order valid
            'status' => 'required|string', // Pastikan status diisi
        ]);

        // Generate code_order once
        $codeOrder = 'SN-' . mt_rand(1000, 9999) . '-' . strtoupper(Str::random(4));

        // Loop melalui setiap ID order yang dipilih
        foreach ($request->product_ids as $orderId) {
            $order = Order::find($orderId);

            // Assign the same code_order to each selected order
            if (!$order->code_order) {
                $order->code_order = $codeOrder; // Assign the generated code_order
            }

            // Now update other fields safely
            $order->status = $request->status;
            $order->is_draft = 'false';
            $order->updated_at = now();
            $order->update();
        }

        return redirect()->route('data-cart')->with('success', 'Order successfully created.');
    }

    public function orderApprove(Request $request, $id)
    {
        $order = Order::find($id);
        $order->status = 'approved';
        $order->total_payment = $request->payment;
        $order->order_date = now();
        $order->save();
        return redirect()->route('order-list')->with('updated', 'Order approved successfully.');
    }

    public function deleteCart($id)
    {
        $order = Order::find($id);

        if ($order->img_sample && Storage::disk('public')->exists($order->img_sample)) {
            Storage::disk('public')->delete($order->img_sample);
        }

        $order->delete();
        return redirect()->route('data-cart')->with('deleted', 'Product cart deleted successfully.');
    }

    public function deleteOrder($id)
    {
        $order = Order::find($id);
        if ($order->img_sample && Storage::disk('public')->exists($order->img_sample)) {
            Storage::disk('public')->delete($order->img_sample);
        }
        $order->delete();
        return redirect()->route('data-order')->with('deleted', 'Product order deleted successfully.');
    }

    public function updatePaymentStatus($codeOrder)
    {
        try {
            // Cari semua order yang memiliki code_order yang sama
            $ordersToUpdate = Order::where('code_order', $codeOrder)->get();

            if ($ordersToUpdate->isEmpty()) {
                // Jika tidak ada order dengan code_order tersebut, beri respons error
                return response()->json([
                    'message' => 'No orders found with the given code.'
                ], 404);
            }

            // Update status pembayaran pada semua order yang memiliki code_order yang sama
            foreach ($ordersToUpdate as $orderToUpdate) {
                $orderToUpdate->payment_status = 'Paid'; // Update status pembayaran
                $orderToUpdate->save();
            }

            // Mengembalikan response sukses
            return response()->json([
                'message' => 'Payment status updated successfully.',
                'orders' => $ordersToUpdate // Mengirimkan data order yang diperbarui
            ]);
        } catch (\Exception $e) {
            // Log the exception for more details
            \Log::error('Error updating payment status: ' . $e->getMessage());

            return response()->json([
                'message' => 'An error occurred while updating the payment status.'
            ], 500);
        }
    }

    public function orderProgressSetting()
    {
        $order_progress = OrderProgressSetting::all();
        return view('order.order-progress-setting', compact('order_progress'));
    }

    public function saveOrderProgressSetting(Request $request)
    {
        $order_progress = new OrderProgressSetting;
        $order_progress->name_progress = $request->progress_name;
        $order_progress->save();
        return redirect()->route('order-progress-setting')->with('success', 'Order progress setting updated successfully.');
    }

    public function updateOrderProgressSetting(Request $request, $id)
    {
        $order_progress = OrderProgressSetting::find($id);
        $order_progress->name_progress = $request->progress_name;
        $order_progress->save();
        return redirect()->route('order-progress-setting')->with('updated', 'Order progress setting updated successfully.');
    }

    public function deleteOrderProgressSetting($id)
    {
        $order_progress = OrderProgressSetting::find($id);
        $order_progress->delete();
        return redirect()->route('order-progress-setting')->with('deleted', 'Order progress setting deleted successfully.');
    }

    public function orderProgressUpdate(Request $request)
    {
        $order = new OrderProgress();
        $order->order_id = $request->order_id;
        $order->code_order = $request->code_order;
        $order->name_progress = $request->progress_name ?? ($request->status === 'finish' ? 'Finished' : null);
        $order->status = $request->status ?? 'progress';
        $order->save();
        return redirect()->route('order-progress')->with('success', 'Order progress updated successfully.');
    }

    public function orderProgressDelete($id)
    {
        $order = OrderProgress::find($id);
        $order->delete();
        return redirect()->route('order-progress')->with('deleted', 'Order progress deleted successfully.');
    }

    public function orderShippingUpdate(Request $request)
    {
        // Pastikan ada daftar order yang dipilih
        if (!$request->has('products') || empty($request->products)) {
            return redirect()->route('order-shipping')->with('error', 'Tidak ada order yang dipilih.');
        }

        // Buat satu kode pengiriman untuk semua order
        $codeShipping = 'SP-' . mt_rand(1000, 9999) . '-' . strtoupper(Str::random(4));

        // Simpan ke setiap order yang dipilih
        foreach ($request->products as $orderId) {
            OrderShipping::create([
                'code_shipping' => $codeShipping,
                'order_id' => $orderId,
            ]);
        }

        return redirect()->route('order-shipping')->with('success', 'Order shipping updated successfully.');
    }

    public function orderShippingDetail($code_shipping)
    {
        $order_shipping = OrderShipping::where('code_shipping', $code_shipping)->get();

        $order_shipping_list = OrderShipping::with('order.product') // Pastikan relasi sudah benar
            ->where('code_shipping', $code_shipping)
            ->get();

        $order_progress_list = OrderProgress::with('order')
            ->where('status', 'finish')
            ->whereNotIn('order_id', function ($query) {
                $query->select('order_id')->from('order_shippings');
            })
            ->get();

        return view('order.order-shipping-detail', compact('order_shipping', 'order_shipping_list', 'order_progress_list'));
    }

    public function orderShippingDelete($id)
    {
        $order_shipping = OrderShipping::find($id);
        $order_shipping->delete();
        return redirect()->route('order-shipping')->with('deleted', 'Order shipping deleted successfully.');
    }

    public function orderShippingListUpdate(Request $request)
    {
        // Pastikan ada daftar order yang dipilih
        if (!$request->has('products') || empty($request->products)) {
            return redirect()->route('order-shipping')->with('error', 'Tidak ada order yang dipilih.');
        }

        // Buat satu kode pengiriman untuk semua order
        $codeShipping = $request->code_shipping;

        // Simpan ke setiap order yang dipilih
        foreach ($request->products as $orderId) {
            OrderShipping::create([
                'code_shipping' => $codeShipping,
                'order_id' => $orderId,
            ]);
        }

        return redirect()->route('order-shipping')->with('success', 'Order shipping updated successfully.');
    }

    public function orderShippingPrint($codeShipping)
    {
        $order_shipping = OrderShipping::where('code_shipping', $codeShipping)->get();
        $order_shipping_list = OrderShipping::with('order.product', 'order.user') // Pastikan relasi sudah benar
            ->where('code_shipping', $codeShipping)
            ->get();
        return view('order.order-shipping-print', compact('order_shipping', 'order_shipping_list'));
    }
}
