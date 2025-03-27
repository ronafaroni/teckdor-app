<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\ProductImg;
use App\Models\ProductStock;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function dataProduct()
    {
        $data_product = Product::with([
            'category',
            'supplier',
            'images'
        ])
            ->withSum('productStocks', 'stock') // Total stok dari productStocks
            ->withSum([
                'orders' => function ($query) {
                    $query->where('status', 'approved'); // Hanya hitung qty dari order yang berstatus approved
                }
            ], 'qty') // Total qty dari orders yang approved
            ->orderBy('created_at', 'desc')
            ->get();

        $category = Category::all();
        $supplier = Supplier::all();
        return view('product.data-product', compact('data_product', 'category', 'supplier'));
    }

    public function addProduct()
    {
        $category = Category::all();
        $supplier = Supplier::all();
        return view('product.add-product', compact('category', 'supplier'));
    }

    public function historyStock()
    {
        $data_product = Product::with([
            'category',
            'supplier',
            'images'
        ])->withSum('productStocks', 'stock')->get();
        $stocks = ProductStock::with('product')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('product.history-product', compact('stocks', 'data_product'));
    }

    public function saveProduct(Request $request)
    {
        $request->validate([
            'product_name' => 'required',
            'description' => 'required',
            'category_name' => 'required',
            'supplier_name' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'length' => 'nullable',
            'width' => 'nullable',
            'height' => 'nullable',
            'weight' => 'nullable',
            'product_status' => 'required',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'images_product' => 'nullable|array',  // Menambahkan validasi untuk multiple images
            'images_product.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // Validasi setiap gambar
        ]);

        // Simpan data produk
        $product = Product::create([
            'code_product' => "P-" . sprintf("%04d", rand(1000, 9999)),
            'name_product' => $request->product_name,
            'description' => $request->description,
            'category_id' => $request->category_name,
            'supplier_id' => $request->supplier_name,
            'price' => $request->price,
            'stock' => $request->stock,
            'length' => $request->length,
            'width' => $request->width,
            'height' => $request->height,
            'weight' => $request->weight,
            'status' => $request->product_status,
        ]);

        // Simpan gambar thumbnail produk
        $thumbnailPath = $request->file('thumbnail')->store('thumbnail', 'public'); // Menyimpan gambar di folder storage/public/thumbnail
        $product->thumbnail = $thumbnailPath;
        $product->save();

        // Simpan gambar produk tambahan (multiple)
        if ($request->hasFile('images_product')) {
            foreach ($request->file('images_product') as $image) {
                $imagePath = $image->store('product_images', 'public'); // Menyimpan gambar di folder storage/public/product_images

                // Pastikan bahwa $product sudah ada dan memiliki ID yang benar
                if ($product->id) {
                    // Simpan informasi gambar di tabel product_images
                    ProductImg::create([
                        'product_id' => $product->id, // Gunakan $product->id, bukan $product->product_id
                        'img_product' => $imagePath,
                    ]);
                }
            }
        }

        return redirect()->route('data-product')->with('success', 'Product added successfully');
    }

    public function editProduct($id)
    {
        $product = Product::with('images')->find($id);
        $category = Category::all();
        $supplier = Supplier::all();
        return view('product.edit-product', compact('product', 'category', 'supplier'));
    }

    public function updateProduct(Request $request)
    {
        $request->validate([
            'product_name' => 'required',
            'description' => 'required',
            'category_name' => 'required',
            'supplier_name' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'length' => 'nullable',
            'width' => 'nullable',
            'height' => 'nullable',
            'weight' => 'nullable',
            'product_status' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Thumbnail bisa null
            'images_product' => 'nullable|array',  // Menambahkan validasi untuk multiple images
            'images_product.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // Validasi setiap gambar
        ]);

        // Perbarui data produk
        $product = Product::find($request->product_id);
        $product->name_product = $request->product_name;
        $product->description = $request->description;
        $product->category_id = $request->category_name;
        $product->supplier_id = $request->supplier_name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->length = $request->length;
        $product->width = $request->width;
        $product->height = $request->height;
        $product->weight = $request->weight;
        $product->status = $request->product_status;

        // Menangani Thumbnail
        if ($request->hasFile('thumbnail')) {
            // Hapus thumbnail lama jika ada
            if ($product->thumbnail) {
                Storage::disk('public')->delete($product->thumbnail);
            }

            // Simpan thumbnail baru
            $thumbnailPath = $request->file('thumbnail')->store('thumbnail', 'public');
            $product->thumbnail = $thumbnailPath;
        }

        // Simpan perubahan data produk
        $product->update();


        // Menangani gambar produk tambahan
        if ($request->hasFile('images_product')) {
            foreach ($request->file('images_product') as $image) {
                // Menyimpan gambar baru
                $imagePath = $image->store('product_images', 'public'); // Menyimpan gambar di folder storage/public/product_images

                // Simpan gambar baru di tabel product_images
                ProductImg::create([
                    'product_id' => $product->id,
                    'img_product' => $imagePath,
                ]);
            }
        }

        // Menangani penghapusan gambar
        if ($request->has('remove_images')) {
            foreach ($request->remove_images as $imageId) {
                // Cari gambar berdasarkan ID
                $image = ProductImg::find($imageId);
                if ($image) {
                    // Hapus gambar dari storage
                    Storage::delete('public/' . $image->img_product);

                    // Hapus record gambar dari database
                    $image->delete();
                }
            }
        }

        return redirect()->route('data-product')->with('updated', 'Product updated successfully');
    }

    public function deleteImage(Request $request, $imageId)
    {
        // Temukan gambar berdasarkan ID
        $image = ProductImg::find($imageId);

        if ($image) {
            // Hapus gambar dari storage
            Storage::disk('public')->delete($image->img_product);

            // Hapus gambar dari database
            $image->delete();

            // Return response sukses
            return response()->json(['success' => true]);
        }

        // Jika gambar tidak ditemukan
        return response()->json(['success' => false, 'message' => 'Image not found']);
    }

    public function deleteProduct($id)
    {
        // Cari produk berdasarkan ID dan muat relasi 'images'
        $product = Product::with('images')->find($id);

        // Cek jika produk ditemukan
        if (!$product) {
            return redirect()->route('data-product')->with('error', 'Product not found');
        }

        // Hapus thumbnail jika ada
        if ($product->thumbnail) {
            \Log::info("Thumbnail exists: {$product->thumbnail}");

            // Periksa apakah file thumbnail ada di storage disk 'public'
            if (Storage::disk('public')->exists($product->thumbnail)) {
                // Hapus file thumbnail
                Storage::disk('public')->delete($product->thumbnail);
                \Log::info("Thumbnail deleted: {$product->thumbnail}");
            } else {
                \Log::warning("Thumbnail not found: {$product->thumbnail}");
            }
        }

        // Hapus gambar tambahan terkait produk
        foreach ($product->images as $image) {
            \Log::info("Deleting image: {$image->img_product}");

            // Periksa apakah file ada di storage disk 'public'
            if (Storage::disk('public')->exists($image->img_product)) {
                // Hapus file dari storage disk 'public'
                Storage::disk('public')->delete($image->img_product);
                \Log::info("Image deleted: {$image->img_product}");
            } else {
                \Log::warning("Image not found: {$image->img_product}");
            }

            // Hapus data gambar dari database
            $image->delete();
        }

        // Setelah semua gambar terhapus, baru hapus produk
        $product->delete();

        return redirect()->route('data-product')->with('deleted', 'Product deleted successfully');
    }

    public function updateStock(Request $request)
    {
        $stock = new ProductStock();
        $stock->product_code = $request->code_product;
        $stock->stock = $request->stock;
        $stock->save();

        return redirect()->route('data-product')->with('updated', 'Stock updated successfully');
    }

    public function updateStock1(Request $request)
    {
        $stock = new ProductStock();
        $stock->product_code = $request->code_product;
        $stock->stock = $request->stock;
        $stock->save();

        return redirect()->route('history-stock')->with('updated', 'Stock updated successfully');
    }

    public function updateHistoryStock(Request $request, $id)
    {
        $stock = ProductStock::find($id);
        $stock->stock = $request->stock;
        $stock->save();

        return redirect()->route('history-stock')->with('updated', 'Stock updated successfully');
    }

    public function deleteHistoryStock($id)
    {
        $stock = ProductStock::find($id);
        $stock->delete();

        return redirect()->route('history-stock')->with('deleted', 'Stock deleted successfully');
    }

}