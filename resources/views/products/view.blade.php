<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product :product Details', ['product' => $product->name]) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('products.view', $product->slug) }}" method="GET">
                        @foreach($attributes as $id => $name)
                            @if(isset($options[$id]))
                                <div class="mb-4">
                                    <label class="text-xl text-gray-600"> {{ $name }} </label>
                                    <select name="attributes[{{ $id }}]"
                                            class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded"
                                            required>
                                        @foreach($options[$id] as $option)
                                            <option value="{{ $option['id'] }}"
                                            @if(request()->query('attributes'))
                                                @selected($option['id'] == request()->query('attributes', '')[$id])
                                                    @endif>
                                                {{ $option['value'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                        @endforeach

                        <div class="mb-4">
                            <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Find price
                            </button>
                        </div>
                    </form>

                    @if($price)
                        <div class="mt-4">
                            @if($price['found'])
                                <p>
                                    <span class="text-xl font-bold">Price</span>
                                    <span>${{ number_format($price['price'], 2) }}</span><br/>
                                    <small>{{ $price['sku'] }}</small>
                                </p>
                            @else
                                <p>We could not find a price for this combination</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
