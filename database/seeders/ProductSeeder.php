<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeOption;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $attributesByName = Attribute::pluck('id', 'name')->toArray();

        $products = [
            [
                'name' => 'Samsung Galaxy S21',
                'SKUs' => [
                    [
                        'price' => 349,
                        'attributes' => [
                            'Color' => 'Red', 'RAM' => '2GB', 'Storage' => '32GB'
                        ],
                    ],
                    [
                        'price' => 349,
                        'attributes' => [
                            'Color' => 'Green', 'RAM' => '4GB', 'Storage' => '32GB'
                        ],
                    ],
                    [
                        'price' => 349,
                        'attributes' => [
                            'Color' => 'Yellow', 'RAM' => '8GB', 'Storage' => '32GB'
                        ],
                    ],
                    [
                        'price' => 1099,
                        'attributes' => [
                            'Color' => 'Blue', 'RAM' => '8GB', 'Storage' => '512GB'
                        ],
                    ],
                    [
                        'price' => 1499,
                        'attributes' => [
                            'Color' => 'Black', 'RAM' => '16GB', 'Storage' => '1TB'
                        ],
                    ],
                ]
            ],
            [
                'name' => 'iPhone 14 MAX',
                'SKUs' => [
                    [
                        'price' => 449,
                        'attributes' => [
                            'Color' => 'Red', 'RAM' => '2GB', 'Storage' => '32GB'
                        ],
                    ],
                    [
                        'price' => 449,
                        'attributes' => [
                            'Color' => 'Green', 'RAM' => '4GB', 'Storage' => '32GB'
                        ],
                    ],
                    [
                        'price' => 449,
                        'attributes' => [
                            'Color' => 'Yellow', 'RAM' => '8GB', 'Storage' => '32GB'
                        ],
                    ],
                    [
                        'price' => 1299,
                        'attributes' => [
                            'Color' => 'Blue', 'RAM' => '8GB', 'Storage' => '512GB'
                        ],
                    ],
                    [
                        'price' => 1999,
                        'attributes' => [
                            'Color' => 'Blue', 'RAM' => '16GB', 'Storage' => '512GB'
                        ],
                    ],
                ]
            ]
        ];

        foreach ($products as $product) {
            DB::transaction(function () use ($product, $attributesByName) {
                $DBProduct = Product::create([
                    'name' => $product['name'],
                    'slug' => str($product['name'])->slug()
                ]);

                foreach ($product['SKUs'] as $sku) {
                    $skuCode = str($product['name']);
                    $skuOptions = [];
                    foreach ($sku['attributes'] as $name => $value) {
                        $skuCode .= ' ' . $value . ' ' . $name;
                        if (!array_key_exists($name, $attributesByName)) {
                            $this->command->error('Attribute ' . $name . ' not found');
                            return;
                        }
                        $attributeOption = AttributeOption::where('attribute_id', $attributesByName[$name])->where('value', $value)->value('id');
                        if (!$attributeOption) {
                            $this->command->error('Attribute Value ' . $name . ' => ' . $value . ' not found');
                            return;
                        }
                        $skuOptions[] = $attributeOption;
                    }
                    $sku = $DBProduct->skus()->create([
                        'code' => str()->slug($skuCode),
                        'price' => $sku['price']
                    ]);
                    $sku->attributeOptions()->attach($skuOptions);
                }
            });
        }
    }
}
