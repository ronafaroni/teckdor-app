<?php

namespace App\Http\Controllers;

use App\Exports\OrderShippingExport;
use App\Exports\ReportLogExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Models\OrderShipping;
use App\Models\Order;

class OrderShippingExportController extends Controller
{
    public function exportExcel($codeShipping)
    {
        $date = date('d-m-Y');

        // Ambil data berdasarkan kode shipping, sertakan relasi yang diperlukan
        $data = OrderShipping::with(['order.product', 'order.user'])
            ->where('code_shipping', $codeShipping)
            ->get();

        // Cek apakah data ditemukan
        if ($data->isEmpty()) {
            return redirect()->back()->with('error', 'Data not found.');
        }

        return Excel::download(new OrderShippingExport($data), "Order-Shipping_{$date}_{$codeShipping}.xlsx");
    }

    public function reportLogExport(Request $request)
    {
        $start_date = $request->input('start_date') ? \Carbon\Carbon::parse($request->input('start_date'))->format('Y-m-d') : 'N/A';
        $end_date = $request->input('end_date') ? \Carbon\Carbon::parse($request->input('end_date'))->format('Y-m-d') : 'N/A';

        $reportLog = Order::with([
            'product.category',
            'product.supplier',
            'user',
            'finance',
            'orderProgress',
            'orderShipping'
        ])
            ->where('is_draft', 'false')
            ->when($request->input('start_date'), function ($query) use ($request) {
                return $query->whereDate('order_date', '>=', $request->input('start_date'));
            })
            ->when($request->input('end_date'), function ($query) use ($request) {
                return $query->whereDate('order_date', '<=', $request->input('end_date'));
            })
            ->get();

        return Excel::download(new ReportLogExport($reportLog, $start_date, $end_date), "Report_TeckDor_{$start_date}_{$end_date}.xlsx");
    }

}
