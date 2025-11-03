<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('service')->orderBy('sort_order')->get();
        return view('admin.products.index', compact('products'));
    }

    public function create(Request $request)
    {
        $service = null;
        if ($request->filled('service_id')) {
            $service = Service::findOrFail($request->input('service_id'));
        }
        $services = $service ? collect() : Service::active()->orderBy('name')->get();
        return view('admin.products.create', compact('services', 'service'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5048',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $data = $request->only(['service_id', 'name', 'description', 'price', 'is_active', 'sort_order']);
        $data['features'] = array_values(array_filter($request->input('features', []), fn($f) => filled($f)));
        
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()
            ->route('admin.services.show', $data['service_id'])
            ->with('success', 'Product berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        // Service tidak bisa diganti dari halaman edit ketika dalam konteks layanan
        $services = collect();
        $service = $product->service;
        return view('admin.products.edit', compact('product', 'services', 'service'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5048',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $data = $request->only(['service_id', 'name', 'description', 'price', 'is_active', 'sort_order']);
        $data['features'] = array_values(array_filter($request->input('features', []), fn($f) => filled($f)));
        
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()
            ->route('admin.services.show', $data['service_id'])
            ->with('success', 'Product berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        $serviceId = $product->service_id;
        $product->delete();

        return redirect()->route('admin.services.show', $serviceId)->with('success', 'Product berhasil dihapus.');
    }
}
