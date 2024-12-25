<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\UpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\Cache;

class ProductController extends Controller
{
    /**
     * @param $productId
     * @return ProductResource
     */
    public function show($productId): ProductResource
    {
        $product = Cache::get('product.' . $productId, fn() => Product::findOrFail($productId), 3600 /*1hour*/);

        return ProductResource::make($product);
    }

    /**
     * @param UpdateRequest $request
     * @param Product $product
     * @return ProductResource
     */
    public function update(UpdateRequest $request, Product $product): ProductResource
    {
        $data = $request->validated();

        $product->update($data);

        Cache::forget('product.' . $product->id);

        return ProductResource::make($product);
    }
}
