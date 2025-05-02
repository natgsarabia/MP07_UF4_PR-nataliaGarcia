<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //FUNCIONES DEVOLVER PRODUCTOS
    /**
     * @OA\Get(
     *     path="/api/products",
     *     summary="Llista tots els productes",
     *     security={{"sanctum": {}}},
     *     @OA\Response(response="200", description="Llista de productes")
     * )
     */
    public function findAll()
    {
       //devolvemos todos los productos
       $products = Product::all();
       return response()->json($products, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/products/{id}",
     *     summary="Mostrar un producte concret",
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
    *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Producte trobat correctament"
     *     )
     * )
     */

    //buscamos un producto unicamente
    public function showOne($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product, 200);
    }

    //FFUNCION CREAR PRODUCTO
    /**
     * @OA\Post(
     *     path="/api/products",
     *     summary="Crea un nou producte",
     *     security={{"sanctum": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "category", "price"},
     *             @OA\Property(property="name", type="string", example="Producte 1"),
     *             @OA\Property(property="category", type="string", example="category"),
     *             @OA\Property(property="price", type="number", example=100.50)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Producte creat correctament"
     *     )
     * )
     */

    public function store(ProductRequest  $request)
    {
        try {
            $product = Product::create($request->validated());
            return response()->json($product, 201);
        } catch (\Throwable $e) {
            \Log::error('Error al crear producto: ' . $e->getMessage());
            return response()->json(['error' => 'Error intern'], 500);
        }
    }
   

    //FUNCION ACTUALIZAR PRODUCTO
    /**
     * @OA\Put(
     *     path="/api/products/{id}",
     *     summary="Actualitzar un nou producte",
     *     security={{"sanctum": {}}},
     * *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "category", "price"},
     *             @OA\Property(property="name", type="string", example="Producte 1"),
     *             @OA\Property(property="category", type="string", example="categoria"),
     *             @OA\Property(property="price", type="number", example=100.50)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Producte actualitzat correctament"
     *     )
     * )
     */
    public function update(ProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->validated());
        return response()->json($product);
    }

    //FUNCION ELIMINAR PRODUCTO
    /**
     * @OA\Delete(
     *     path="/api/products/{id}",
     *     summary="Eliminar un producte",
     *     security={{"sanctum": {}}},
     * *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Producte eliminat correctament"
     *     )
     * )
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(['message' => 'Producte eliminat correctament'], 200);
    }
}
