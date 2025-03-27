<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Finance;
use App\Models\SupplierPayment;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function admin()
    {

        return view('template.admin');
    }

    public function customer()
    {

        return view('template.customer');
    }

    public function finance()
    {

        return view('template.finance');
    }

    public function adminDashboard()
    {
        $product = Product::with('images', 'category', 'supplier')
            ->withSum('productStocks', 'stock') // Total stok dari productStocks
            ->withSum([
                'orders' => function ($query) {
                    $query->where('status', 'approved'); // Hanya hitung qty dari order yang berstatus approved
                }
            ], 'qty')
            ->get();

        // Hitung jumlah customer unik yang memiliki order dengan status 'approved'
        $customerCount = Order::where('status', 'approved')
            ->distinct('user_id') // Ambil customer unik berdasarkan user_id
            ->count('user_id'); // Hitung jumlah customer unik

        // Ambil data order dengan status 'approved' dan kelompokkan berdasarkan 'code_order'
        $orders = Order::where('status', 'approved')
            ->selectRaw('code_order, COUNT(*) as total_orders')
            ->groupBy('code_order')
            ->get();

        // Hitung jumlah code_order unik
        $orderCount = $orders->count();

        // Hitung jumlah order yang sudah dibayarkan
        $totalPayment = Finance::sum('total_payment');

        $orderLog = Order::with('product.supplier', 'user')
            ->where('is_draft', 'false')
            ->orderBy('updated_at', 'asc')
            ->get()
            ->groupBy('code_order');

        return view('dashboard.admin-dashboard', compact('product', 'customerCount', 'orderCount', 'totalPayment', 'orderLog'));
    }

    public function financeDashboard()
    {
        $total = Order::where('status', 'approved')
            ->where('is_draft', false)
            ->select(DB::raw('SUM(qty * total_payment) as total'))
            ->first()
            ->total;

        $payment = Finance::sum('total_payment');

        $supplierPayment = SupplierPayment::sum('total_payment');

        return view('dashboard.finance-dashboard', [
            'total' => $total,
            'payment' => $payment,
            'supplierPayment' => $supplierPayment
        ]);
    }

    public function customerDashboard()
    {
        // Ambil data produk dengan relasi dan jumlah stok serta pesanan
        $product = Product::with('images', 'category', 'supplier')
            ->withSum('productStocks', 'stock') // Total stok dari productStocks
            ->withSum([
                'orders' => function ($query) {
                    $query->where('status', 'approved'); // Hanya hitung qty dari order yang berstatus approved
                }
            ], 'qty')
            ->get();

        // Ambil data kategori dengan relasi produk
        $category = Category::with('products')->get();

        return view('dashboard.customer-dashboard', compact('category', 'product'));
    }
}
