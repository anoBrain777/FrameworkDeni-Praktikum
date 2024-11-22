<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use App\Models\product;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Inisialisasi query untuk mengambil data produk
        $query = Product::query();

        // Cek apakah ada parameter 'search' di request
        if ($request->has('search') && $request->search != '') {
            // Ambil kata kunci pencarian
            $search = $request->search;

            // Tambahkan kondisi pencarian pada query
            $query->where(function ($q) use ($search) {
                $q->where('product_name', 'like', '%' . $search . '%')  // Pencarian berdasarkan nama produk
                  ->orWhere('producer', 'like', '%' . $search . '%'); // Pencarian berdasarkan produsen (optional)
            });
        }

        // Ambil data produk sesuai query, dengan pagination
        $data = $query->paginate(10);  // Ganti 10 dengan jumlah per halaman yang diinginkan

        // Kembalikan view dengan data produk
        return view("master-data.product-master.index-product", compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("master-data.product-master.create-product");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input data
        $validasi_data = $request->validate([
            'product_name' => 'required|string|max:255',
            'unit'         => 'required|string|max:50',
            'type'         => 'required|string|max:50',
            'information'  => 'nullable|string',
            'qty'          => 'required|integer',
            'producer'     => 'required|string|max:255',
        ]);

        // Proses simpan data ke dalam database
        Product::create($validasi_data);

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        return view('master-data.product-master.edit-product', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'information' => 'nullable|string',
            'qty' => 'required|integer|min:1',
            'producer' => 'required|string|max:255',
        ]);

        $product = Product::findOrFail($id);
        $product->update([
            'product_name' => $request->product_name,
            'unit' => $request->unit,
            'type' => $request->type,
            'information' => $request->information,
            'qty' => $request->qty,
            'producer' => $request->producer,
        ]);

        return redirect()->back()->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            return redirect()->route('product.index')->with('success', 'Product berhasil dihapus.');
        }
        return redirect()->route('product.index')->with('error', 'Product tidak ditemukan.');
    }
    public function exportExcel (){
        return Excel::download(new ProductsExport,'product.xlsx');
    }
}
