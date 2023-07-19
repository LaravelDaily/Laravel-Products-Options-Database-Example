<?php

namespace App\Http\Controllers;

use App\Models\Product;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $products = Product::all();

        return view('dashboard', ['products' => $products]);
    }
}
