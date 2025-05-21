<div 
    wire:key="item-{{ $item['id'] }}"
    wire:click="selectItem('{{ $item['id'] }}', '{{ $item['name_fa'] ?? $item['name'] }}')"
    class="p-2 hover:bg-blue-100 cursor-pointer flex justify-between"
>
    <span>{{ $item['name_fa'] ?? $item['name'] }}</span>
</div>