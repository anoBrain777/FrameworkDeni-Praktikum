<?php

namespace App\Http\Controllers;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function create()
    {
        return view('master-data.supplier-master.create-supplier');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'comment' => 'nullable|string|max:255',
        ]);

        Supplier::create([
            'name' => $request->name,
            'contact' => $request->contact,
            'address' => $request->address,
            'comment' => $request->comment,
        ]);

        return redirect()->route('supplier-create')->with('success', 'Supplier created successfully!');
    }
}
