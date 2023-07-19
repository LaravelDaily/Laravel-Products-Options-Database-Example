<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeOption;
use App\Models\Product;
use Illuminate\Database\Seeder;

class LocalSeeder extends Seeder
{
    public function run(): void
    {
        $attributes = [
            [
                'name' => 'Color',
                'values' => [
                    'Red',
                    'Blue',
                    'Green',
                    'Black',
                    'White',
                    'Yellow',
                ],
            ],
            [
                'name' => 'Ram Size',
                'values' => [
                    '2GB',
                    '4GB',
                    '8GB',
                    '16GB',
                ],
            ],
            [
                'name' => 'Storage Size',
                'values' => [
                    '32GB',
                    '64GB',
                    '128GB',
                    '256GB',
                    '512GB',
                    '1TB',
                ],
            ],
        ];

        foreach ($attributes as $attribute) {
            $createdAttribute = Attribute::create(['name' => $attribute['name']]);
            foreach ($attribute['values'] as $value) {
                $createdAttribute->attributeOptions()->create(['value' => $value]);
            }
        }

        $productName = 'Samsung Galaxy S21';
        $samsungPhone = Product::create([
            'name' => $productName,
            'slug' => str($productName)->slug()
        ]);

        $samsungSKUS = [
            [
                'code' => str($productName)->append(' Red 2GB RAM 32GB Storage')->slug(),
                'price' => 349,
                'options' => [
                    AttributeOption::where('attribute_id', 1)->where('value', 'Red')->first()->id,
                    AttributeOption::where('attribute_id', 2)->where('value', '2GB')->first()->id,
                    AttributeOption::where('attribute_id', 3)->where('value', '32GB')->first()->id,
                ]
            ],
            [
                'code' => str($productName)->append(' Green 4GB RAM 32GB Storage')->slug(),
                'price' => 349,
                'options' => [
                    AttributeOption::where('attribute_id', 1)->where('value', 'Green')->first()->id,
                    AttributeOption::where('attribute_id', 2)->where('value', '4GB')->first()->id,
                    AttributeOption::where('attribute_id', 3)->where('value', '32GB')->first()->id,
                ]
            ],
            [
                'code' => str($productName)->append(' Yellow 8GB RAM 32GB Storage')->slug(),
                'price' => 349,
                'options' => [
                    AttributeOption::where('attribute_id', 1)->where('value', 'Yellow')->first()->id,
                    AttributeOption::where('attribute_id', 2)->where('value', '8GB')->first()->id,
                    AttributeOption::where('attribute_id', 3)->where('value', '32GB')->first()->id,
                ]
            ],
            [
                'code' => str($productName)->append(' Blue 8GB RAM 512GB Storage')->slug(),
                'price' => 1099,
                'options' => [
                    AttributeOption::where('attribute_id', 1)->where('value', 'Blue')->first()->id,
                    AttributeOption::where('attribute_id', 2)->where('value', '8GB')->first()->id,
                    AttributeOption::where('attribute_id', 3)->where('value', '512GB')->first()->id,
                ]
            ],
            [
                'code' => str($productName)->append(' Black 16GB RAM 1TB Storage')->slug(),
                'price' => 1499,
                'options' => [
                    AttributeOption::where('attribute_id', 1)->where('value', 'Blue')->first()->id,
                    AttributeOption::where('attribute_id', 2)->where('value', '16GB')->first()->id,
                    AttributeOption::where('attribute_id', 3)->where('value', '512GB')->first()->id,
                ]
            ],
        ];

        foreach ($samsungSKUS as $sku) {
            $createdSKU = $samsungPhone->skus()->create(['code' => $sku['code'], 'price' => $sku['price']]);
            $createdSKU->attributeOptions()->attach($sku['options']);
        }


        $productName2 = 'iPhone 14 MAX';
        $iphone = Product::create([
            'name' => $productName2,
            'slug' => str($productName2)->slug()
        ]);

        $iphoneSKUS = [
            [
                'code' => str($productName2)->append(' Red 2GB RAM 32GB Storage')->slug(),
                'price' => 449,
                'options' => [
                    AttributeOption::where('attribute_id', 1)->where('value', 'Red')->first()->id,
                    AttributeOption::where('attribute_id', 2)->where('value', '2GB')->first()->id,
                    AttributeOption::where('attribute_id', 3)->where('value', '32GB')->first()->id,
                ]
            ],
            [
                'code' => str($productName2)->append(' Green 4GB RAM 32GB Storage')->slug(),
                'price' => 449,
                'options' => [
                    AttributeOption::where('attribute_id', 1)->where('value', 'Green')->first()->id,
                    AttributeOption::where('attribute_id', 2)->where('value', '4GB')->first()->id,
                    AttributeOption::where('attribute_id', 3)->where('value', '32GB')->first()->id,
                ]
            ],
            [
                'code' => str($productName2)->append(' Yellow 8GB RAM 32GB Storage')->slug(),
                'price' => 449,
                'options' => [
                    AttributeOption::where('attribute_id', 1)->where('value', 'Yellow')->first()->id,
                    AttributeOption::where('attribute_id', 2)->where('value', '8GB')->first()->id,
                    AttributeOption::where('attribute_id', 3)->where('value', '32GB')->first()->id,
                ]
            ],
            [
                'code' => str($productName2)->append(' Blue 8GB RAM 512GB Storage')->slug(),
                'price' => 1299,
                'options' => [
                    AttributeOption::where('attribute_id', 1)->where('value', 'Blue')->first()->id,
                    AttributeOption::where('attribute_id', 2)->where('value', '8GB')->first()->id,
                    AttributeOption::where('attribute_id', 3)->where('value', '512GB')->first()->id,
                ]
            ],
            [
                'code' => str($productName2)->append(' Black 16GB RAM 1TB Storage')->slug(),
                'price' => 1999,
                'options' => [
                    AttributeOption::where('attribute_id', 1)->where('value', 'Blue')->first()->id,
                    AttributeOption::where('attribute_id', 2)->where('value', '16GB')->first()->id,
                    AttributeOption::where('attribute_id', 3)->where('value', '512GB')->first()->id,
                ]
            ],
        ];

        foreach ($iphoneSKUS as $sku) {
            $createdSKU = $iphone->skus()->create(['code' => $sku['code'], 'price' => $sku['price']]);
            $createdSKU->attributeOptions()->attach($sku['options']);
        }

    }
}
