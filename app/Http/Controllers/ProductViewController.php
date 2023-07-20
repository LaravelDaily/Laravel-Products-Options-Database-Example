<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductViewController extends Controller
{
    public function __invoke(Request $request, Product $product)
    {
        $product->load([
            'skus.attributeOptions.attribute'
        ]);
        $attributes = Attribute::pluck('name', 'id');

        $allOptions = $this->getSelectableOptionsFromProduct($product);
        $price = $this->calculatePrice($product, $request);

        return view('products.view', [
            'product' => $product,
            'attributes' => $attributes,
            'options' => $allOptions,
            'price' => $price
        ]);
    }

    private function calculatePrice(Product $product, Request $request): ?array
    {
        $price = null;
        if ($request->filled('attributes')) {
            $price = [
                'found' => false,
                'price' => null,
                'sku' => null
            ];

            $skuQuery = $product->skus()->where(function ($q) use ($request) {
                foreach ($request->input('attributes', []) as $attribute => $option) {
                    $q->whereHas('attributeOptions', function (Builder $q) use ($attribute, $option) {
                        return $q->where('id', $option)
                            ->where('attribute_id', $attribute);
                    });
                }
            });
            if ($sku = $skuQuery->first()) {
                $price['found'] = true;
                $price['price'] = $sku->price;
                $price['sku'] = $sku->code;
            }
        }

        return $price;
    }

    private function getSelectableOptionsFromProduct(Product $product): array
    {
        $allOptions = [];

        foreach ($product->skus as $sku) {
            foreach ($sku->attributeOptions->groupBy('attribute_id') as $attributeID => $options) {
                $allOptions[$attributeID][] = $options->toArray();
            }
        }
        foreach ($allOptions as $attribute => $options) {
            // Cleaning up the array to make sure we don't have duplicate values
            $allOptions[$attribute] = collect($options)
                ->flatten(1)
                ->unique('id')
                ->toArray();
        }
        return $allOptions;
    }
}
