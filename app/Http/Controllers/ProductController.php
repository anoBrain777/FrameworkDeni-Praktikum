<?php

namespace App\Http\Controllers;

use App\Models\Product; // Tambahkan ini untuk meng-import model Product
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Product::all();
        return view("master-data.product-master.index-product",compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("master-data.product-master.create-product"); // Tambahkan titik koma
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
        return view('master-data.product-master.edit-product',compact('product'));
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
        $product->update ([
            'product_name' => $request -> product_name,
            'unit' => $request->unit,
            'type' => $request->type,
            'information' => $request->information,
            'qty' => $request->qty,
            'producer' => $request->producer,
        ]);

        return redirect()->back()->with('succes', 'product update succesfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            return redirect()->route('product')->with('success', 'Product berhasil dihapus.');
        }
        return redirect()->route('product')->with('error', 'Product tidak ditemukan.');
    }
}
