<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductViewController extends Controller
{
    public function __invoke(Product $product)
    {
        $product->load([
            'skus'
        ]);

        return view('products.view', ['product' => $product]);
    }
}
