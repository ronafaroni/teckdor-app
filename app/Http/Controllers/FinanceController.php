<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Finance;
use App\Models\SupplierPayment;

class FinanceController extends Controller
{
    public function transactionList()
    {
        $order = Order::with('product', 'user') // Pastikan relasi dipanggil
            ->where('is_draft', 'false')
            ->where('status', 'approved')
            ->orderBy('order_date', 'desc')
            ->get()
            ->groupBy('code_order');

        return view('finance.transaction-list', compact('order'));
    }

    public function transactionLog()
    {
        $payment = Finance::with('order.product', 'order.user')
            ->orderBy('payment_date', 'desc')
            ->get();

        return view('finance.transaction-log', compact('payment'));
    }

    public function transactionDetail($code_order)
    {
        $transactions = Order::with('product.supplier', 'user', 'supplier')
            ->where('is_draft', 'false')
            ->where('status', 'approved')
            ->where('code_order', $code_order)
            ->get();

        $payment = Finance::where('code_order', $code_order)->get();

        return view('finance.transaction-detail', compact('transactions', 'payment'));
    }

    public function transactionPayment(Request $request)
    {
        $request->validate([
            'total_payment' => 'required|numeric|min:1',
            'status_payment' => 'required|string',
        ]);

        $payment = new Finance();
        $payment->code_order = $request->code_order;
        $payment->order_id = $request->order_id;
        $payment->total_payment = $request->total_payment;
        $payment->payment_status = $request->status_payment;
        $payment->payment_date = now();
        $payment->save();

        return response()->json(['message' => 'Payment was successfully saved.']);
    }

    public function deleteTransaction($id)
    {
        try {
            // Cari data pembayaran berdasarkan ID
            $payment = Finance::findOrFail($id);

            // Hapus data pembayaran
            $payment->delete();

            // Mengembalikan response success
            return response()->json([
                'message' => 'Payment deleted successfully!'
            ]);
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, tampilkan pesan error
            return response()->json([
                'message' => 'An error occurred while deleting the payment.'
            ], 500);
        }
    }

    public function paymentSupplierList()
    {
        $payment = Order::with('product.supplier', 'user', 'supplier')
            ->where('is_draft', 'false')
            ->where('status', 'approved')
            ->where('payment_status', 'paid')
            ->get();

        return view('supplier.payment-supplier-list', compact('payment'));
    }

    public function paymentSupplierDetail($product_id)
    {
        // Ambil data order berdasarkan product_id dan kondisi lainnya
        $payment = Order::with('product.supplier', 'user', 'supplier')
            ->where('product_id', $product_id)
            ->where('is_draft', 'false')
            ->where('status', 'approved')
            ->where('payment_status', 'paid')
            ->get(); // Menggunakan get() untuk mengambil semua data yang sesuai

        $supplierPayment = SupplierPayment::where('product_id', $product_id)->get();

        return view('supplier.payment-supplier-detail', compact('payment', 'supplierPayment'));
    }

    public function saveSupplierPayment(Request $request)
    {
        // Validasi input
        $request->validate([
            'total_payment' => 'required|numeric|min:0',
            'status_payment' => 'required|in:unpaid,partially paid,fully paid',
            'code_order' => 'required|string',
            'order_id' => 'required|integer',
            'product_id' => 'required|integer',
            'supplier_id' => 'required|integer',
        ]);

        // Simpan data ke database
        $payment = new SupplierPayment();
        $payment->order_id = $request->order_id;
        $payment->code_order = $request->code_order;
        $payment->product_id = $request->product_id;
        $payment->supplier_id = $request->supplier_id;
        $payment->total_payment = $request->total_payment;
        $payment->payment_status = $request->status_payment;
        $payment->payment_date = now();
        $payment->save();

        // Redirect dengan pesan sukses
        return response()->json([
            'message' => 'Payment was successfully saved.',
            'id' => $payment->id, // ID payment yang baru disimpan
        ]);
    }

    public function deleteSupplierPayment($id)
    {
        try {
            // Cari data pembayaran berdasarkan ID
            $payment = SupplierPayment::findOrFail($id);

            // Hapus data pembayaran
            $payment->delete();

            // Mengembalikan response success
            return response()->json([
                'message' => 'Payment deleted successfully!'
            ], 200); // Status code 200 untuk sukses
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, tampilkan pesan error
            return response()->json([
                'message' => 'An error occurred while deleting the payment.'
            ], 500); // Status code 500 untuk server error
        }
    }

    // Method untuk mengupdate status pembayaran supplier
    public function updateSupplierPaymentStatus($orderId)
    {
        try {
            // Cari order berdasarkan order_id
            $order = Order::findOrFail($orderId);

            // Update status pembayaran supplier
            $order->supplier_payment_status = 'paid';
            $order->save();

            // Kembalikan respons JSON
            return response()->json([
                'message' => 'Supplier payment status updated successfully!',
                'orders' => [$order]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the payment status.'
            ], 500);
        }
    }
}
