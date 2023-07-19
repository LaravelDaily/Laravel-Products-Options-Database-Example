<div>
    @foreach($attributes as $attribute)
        <div class="mb-4">
            <h1>{{ $attribute['name'] }}</h1>
            <div class="grid grid-cols-5">
                @if(isset($optionsList[$attribute['id']]))
                    @foreach($optionsList[$attribute['id']] as $attributeOption)
                        <div class="">
                            <label>
                                <input type="radio" value="{{ $attributeOption['id'] }}"
                                       name="attribute[{{ $attribute['id'] }}][]"
                                       @if(!$loop->parent->first)
                                           @if(count($enabledOptions) > 0 && !in_array($attributeOption['id'], $enabledOptions[$attribute['id']]))
                                                disabled
                                                class="bg-gray-300"
                                           @endif
                                       @endif
                                       wire:model="selectedAttributes.{{$attribute['id']}}">
                                {{ $attributeOption['value'] }}
                            </label>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    @endforeach

    <div>
        <span class="text-xl font-bold">Price:</span> <span>{{ $price }}</span>
    </div>
</div>