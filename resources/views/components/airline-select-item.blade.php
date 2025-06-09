<div 
    wire:key="item-{{ $item['code'] }}"
    wire:click="selectItem('{{ $item['code'] }}', '{{ $item['name_fa'] ?: $item['name'] }}')"
    class="p-2 hover:bg-blue-100 cursor-pointer flex justify-between"
>
    @if ($item['logo'])
        <span>
            <img width="20px" height="20px" src="{{ asset($item['logo']) }}" alt="">
        </span>
    @endif
    <span>{{ $item['name_fa'] ?: $item['name'] }}</span>
    <span class="text-gray-500">{{ $item['code'] }}</span>
</div>