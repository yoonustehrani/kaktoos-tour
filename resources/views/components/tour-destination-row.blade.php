<tr wire:key='{{ $destination->id }}'>
    <td class="p-2 whitespace-nowrap">
        <div class="flex items-center gap-3">
            <button wire:click="removeDestination('{{ $destination->id }}')" type="button" class="bg-red-200 text-red-500 flex items-center justify-center p-1 rounded-lg">
                <i class="fi fi-rs-trash h-5 text-xl"></i>
            </button>
            <div class="w-10 h-10 flex-shrink-0">
                <img
                    class="rounded-full"
                    src="{{ asset('images/flags/1x1/'. strtolower($destination->location['country_code']) .'.svg') }}"
                    width="40" height="40" alt="Alex Shatov">
            </div>
            <div class="font-medium text-gray-800">{{ $destination->location['name'] }} {{ $destination->location['name_fa'] }}</div>
        </div>
    </td>
    <td class="p-2 whitespace-nowrap">
        <div class="text-center">{{ $destination->number_of_nights }} شب</div>
    </td>
    <td class="p-2 whitespace-nowrap">
        <div class="text-center font-medium text-green-500">
            @if ($destination->requires_visa)
                {{ $destination->visa_preparation_days }} روز
            @else
                <span class="text-red-500"><i class="fi fi-rs-cross h-5"></i></span>
            @endif
        </div>
    </td>
    {{-- <td class="p-2 whitespace-nowrap">
        <div class="text-lg text-center">🇺🇸</div>
    </td> --}}
</tr>