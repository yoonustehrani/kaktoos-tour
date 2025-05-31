<div 
    wire:key="item-{{ $item['id'] }}"
    wire:click="selectItem('{{ $item['id'] }}', '{{ $item['name_fa'] ?? $item['name'] }}')"
    class="p-2 hover:bg-blue-100 cursor-pointer flex items-center gap-2 text-base"
>
    <span class="flex rounded-full overflow-hidden"><img class="h-5 w-5" src="{{ asset('images/flags/1x1/' . strtolower($item['country_code']) . '.svg') }}" alt=""></span>
    <span>{{ $item['name'] }}</span>
    <span>{{ $item['name_fa'] ?? '' }}</span>
</div>