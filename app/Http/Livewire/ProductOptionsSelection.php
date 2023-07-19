<?php

namespace App\Http\Livewire;

use App\Models\Attribute;
use App\Models\Product;
use Livewire\Component;

class ProductOptionsSelection extends Component
{
    public Product $product;
    public array $attributes;

    public $optionsList = [];
    public $price = 'Please select options to see the price';
    public $selectedAttributes = [];
    public $enabledOptions = [];

    public function mount(Product $product)
    {
        $product->load(['skus.attributeOptions.attribute']);
        $this->product = $product;
        $this->attributes = Attribute::all()->toArray();

        $this->generateOptions();
    }

    public function render()
    {
        return view('livewire.product-options-selection');
    }

    public function updatedSelectedAttributes()
    {
        $this->enabledOptions = $this->getEnabledOptions();
        $price = $this->getPrice();

        if ($price) {
            $this->price = $price;
        } else {
            $this->price = 'Please select options to see the price';
        }
    }

    private function generateOptions(): void
    {
        $allOptions = [];

        foreach ($this->product->skus as $sku) {
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

        $this->optionsList = $allOptions;
    }

    private function getEnabledOptions()
    {
        $enabledOptions = [];
        foreach ($this->product->skus as $sku) {
            $skuOptions = $sku->attributeOptions->pluck('id')->toArray();

            if (array_intersect($skuOptions, array_values($this->selectedAttributes))) {
                foreach ($sku->attributeOptions->groupBy('attribute_id') as $attributeID => $options) {
                    $enabledOptions[$attributeID][] = $options->pluck('id')->toArray();
                }
            }
        }

        foreach ($enabledOptions as $attribute => $options) {
            // Cleaning up the array to make sure we don't have duplicate values
            $enabledOptions[$attribute] = collect($options)
                ->flatten()
                ->toArray();
        }

        return $enabledOptions;
    }

    private function getPrice()
    {
        if (count($this->selectedAttributes) === count(array_keys($this->optionsList))) {
            $product = $this->product->skus()
                ->whereHas('attributeOptions', function ($query) {
                    $query->whereIn('attribute_option_id', array_values($this->selectedAttributes));
                })
                ->first();
            info($product?->id);

            return $product?->price;
        }
        return null;
    }
}
