<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // GET /api/products
    public function index()
    {
        return response()->json(Product::all(), 200);
    }

    // GET /api/products/{id}
    public function show($id)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return response()->json(["message" => "Producto no encontrado"], 404);
        }
        
        return response()->json($product, 200);
    }

    // POST /api/products
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0.01',
            'stock' => 'required|integer|min:0',
        ]);

        $product = Product::create($validatedData);
        return response()->json(["message" => "Producto creado con exito", "product" => $product], 201);
    }

    // PUT /api/products/{id}
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(["message" => "Producto no encontrado"], 404);
        }

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0.01',
            'stock' => 'required|integer|min:0',
        ]);

        $product->update($validatedData);
        return response()->json(["message" => "Producto actualizado con exito", "product" => $product], 200);
    }

    // DELETE /api/products/{id}
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(["message" => "Producto no encontrado"], 404);
        }

        $product->delete();
        return response()->json(["message" => "Producto eliminado correctamente"], 200);
    }
}
