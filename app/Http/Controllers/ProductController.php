<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use App\Models\product;
use App\Models\supplier;
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
        $query = Product::with('supplier');

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
       // return $data;
        // Kembalikan view dengan data produk
        return view("master-data.product-master.index-product", compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = supplier::all();
        return view("master-data.product-master.create-product",compact('suppliers')) ;
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
            'supplier_id'=> 'required|exists:suppliers,id',
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
    $product = Product::findOrFail($id); // Mendapatkan data produk berdasarkan ID
    $suppliers = Supplier::all(); // Mengambil semua data supplier
    return view('master-data.product-master.edit-product', compact('product', 'suppliers')); // Mengirimkan data produk dan suppliers ke view
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    // Validasi input data
    $validated = $request->validate([
        'product_name' => 'required|string|max:255',
        'unit' => 'required|string|max:255',
        'type' => 'required|string|max:255',
        'information' => 'nullable|string',
        'qty' => 'required|integer|min:1',
        'producer' => 'required|string|max:255',
        'supplier_id' => 'required|exists:suppliers,id', // Validasi supplier_id
    ]);

    // Ambil data produk berdasarkan ID
    $product = Product::findOrFail($id);

    // Update produk dengan data yang telah tervalidasi
    $product->update([
        'product_name' => $validated['product_name'],
        'unit' => $validated['unit'],
        'type' => $validated['type'],
        'information' => $validated['information'],
        'qty' => $validated['qty'],
        'producer' => $validated['producer'],
        'supplier_id' => $validated['supplier_id'],  // Update supplier_id yang sudah tervalidasi
    ]);

    return redirect()->route('product-index')->with('success', 'Product updated successfully');
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
