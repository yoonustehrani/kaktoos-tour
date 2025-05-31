<div x-data="{ open: @entangle('showDropdown') }" class="relative w-full" @click.away="open = false">
    <!-- Selected item (hidden input for form submissions) -->
    <input type="hidden" name="airport_code" wire:model="selectedId">
    
    <!-- Search input -->
    <div @click="open = true" class="cursor-pointer">
        @if($selectedId)
            <div class="p-2 border rounded bg-gray-50">
                {{ $selectedName }}
                <span class="float-left text-gray-400" wire:click='empty'>×</span>
            </div>
        @else
            <input 
                type="text" 
                wire:model.live.debounce.250ms="search"
                wire:keydown.arrow-down="highlightNext"
                wire:keydown.arrow-up="highlightPrev"
                wire:keydown.enter="selectHighlighted"
                placeholder="{{ $placeholder }}"
                class="w-full p-2 border rounded"
                @focus="open = true"
                autocomplete="off"
            >
        @endif
    </div>
    
    <!-- Dropdown menu -->
    <div x-cloak x-show="open" x-transition class="absolute z-20 w-full mt-1 bg-white border rounded shadow-lg max-h-60 overflow-auto">
        @if(count($results) > 0)
            @foreach($results as $item)
                <x-dynamic-component :component="$itemComponent" :$item/>
            @endforeach
        @elseif(strlen($search) > 1)
            <div class="p-2 text-gray-500">
                @lang('No result found for :keyword', ['keyword' => $search])
            </div>
        @endif
    </div>
</div>