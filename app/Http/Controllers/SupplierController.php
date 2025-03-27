<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function dataSupplier()
    {
        $data_supplier = Supplier::orderBy('created_at', 'desc')->get();
        return view('supplier.data-supplier', compact('data_supplier'));
    }

    public function saveSupplier(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|numeric',
        ]);

        $supplier = new Supplier;
        $supplier->name_supplier = $validated['name'];
        $supplier->address = $validated['address'];
        $supplier->phone = $validated['phone'];
        $supplier->save();

        return redirect()->route('data-supplier')->with('success', 'Data saved successfully.');
    }

    public function editSupplier($id)
    {
        $supplier = Supplier::find($id);
        return view('supplier.edit-supplier', compact('supplier'));
    }

    public function updateSupplier(Request $request)
    {
        $request->validate([
            'name_supplier' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);

        $supplier = Supplier::find($request->id);
        $supplier->name_supplier = $request->name_supplier;
        $supplier->phone = $request->phone;
        $supplier->address = $request->address;
        $supplier->update();

        return redirect()->route('data-supplier')->with('updated', 'Data updated successfully.');
    }

    public function deleteSupplier($id)
    {
        $supplier = Supplier::find($id);
        $supplier->delete();
        return redirect()->route('data-supplier')->with('deleted', 'Data deleted successfully.');
    }
}
