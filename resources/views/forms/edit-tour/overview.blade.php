<x-sidebar :tour='$tour_form->tour'>
    <div class="absolute top-3 left-3 flex gap-2">
    <a class="p-2 rounded-md shadow-sm text-gray-200 bg-gray-900" href="{{ route('tours.edit', ['tour' => $tour_form->tour->id, 'section' => 'initial-data']) }}" wire:navigate><i class="block size-4 fi fi-rs-pencil"></i></a>
    </div>
</x-sidebar>
<div class="w-auto h-full flex-grow bg-gray-100 duration-300">
</div>