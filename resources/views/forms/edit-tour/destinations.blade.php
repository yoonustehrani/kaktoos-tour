<x-sidebar :tour='$tour_form->tour'>
    <div class="absolute top-3 left-3 flex gap-2">
    <a class="p-2 rounded-md shadow-sm text-gray-200 bg-gray-900" href="{{ route('tours.edit', ['tour' => $tour_form->tour->id, 'section' => 'initial-data']) }}" wire:navigate><i class="block size-4 fi fi-rs-pencil"></i></a>
    </div>
</x-sidebar>
<div class="w-auto h-full flex-grow bg-gray-100 duration-300">
    <div
        class="h-full max-h-full w-full overflow-y-auto gap-6 gap-y-8 place-content-start grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 p-8">
        <div class="col-span-2">
            <div class="h-full">
                <!-- Table -->
                <div class="w-full max-w-full mx-auto bg-white shadow-lg rounded-md border border-gray-200">
                    <header class="px-5 py-4 border-b border-gray-100">
                        <div class="flex items-center gap-3">
                            <h4 class="font-bold text-xl flex items-center gap-2"><i class="h-5 fi fi-rs-route"></i>مقصدها</h4>
                            <button class="border border-gray-700 py-1 px-3 rounded-md shadow-md" type="button"
                                wire:click='toggleDisplay'>افزودن مقصد</button>
                        </div>
                    </header>
                    <div class="p-3">
                        <div class="overflow-x-auto">
                            <table class="table-auto w-full">
                                <thead class="text-xs font-semibold uppercase text-gray-400 bg-gray-50">
                                    <tr>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-center">نام مقصد</div>
                                        </th>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-center">اقامت</div>
                                        </th>
                                        <th class="p-2 whitespace-nowrap">
                                            <div class="font-semibold text-center">اخذ ویزا</div>
                                        </th>
                                    </tr>
                                </thead>
                                @if ($destinations)
                                <tbody class="text-sm divide-y divide-gray-100">
                                    @foreach ($destinations as $destination)
                                    <x-tour-destination-row :$destination />
                                    @endforeach
                                </tbody>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<dialog id="new-destination-dialog" @if($displayDialog) open @endif>
    <form wire:submit='addDestination' class="bg-white grid grid-cols-1 gap-4 p-6 rounded-md">
        <div>
            <div class="w-full flex items-center justify-between">
                <h4 class="text-2xl font-bold">افزودن مقصد به این تور</h4>
                <button type="button" wire:click='toggleDisplay'><i class="h-5 fi fi-rs-cross"></i></button>
            </div>
            <hr class="opacity-70 mt-3">
        </div>
        <div class="min-w-96 relative">
            <span class="absolute z-50 -top-2 right-2 text-xs py-1 px-2 rounded-full bg-white">لوکیشن مقصد
                *</span>
            <livewire:location-select :key='\Str::random(8)'
                :selectedId="$destination_form->location_id ?? null" placeholder="جستجوی مقصد ..."
                eventName="destination-item-selected" pro />

        </div>
        <div class="min-w-96 relative flex">
            <span class="absolute -top-2 right-2 text-xs py-1 px-2 rounded-full bg-white">تعداد شب ها *</span>
            <input type="number" wire:model='destination_form.number_of_nights'
                class="w-full h-full shadow-sm border border-black/10 py-3 px-4 rounded-md">
        </div>
        <div class="flex items-center gap-2"
            x-data="{toggle: $wire.destination_form.requires_visa ? '1' : '0'}">
            <div class="relative rounded-full w-12 h-6 transition duration-200 ease-linear"
                :class="[toggle === '1' ? 'bg-sky-400' : 'bg-gray-400']">
                <label for="toggle"
                    class="absolute left-0 bg-white border-2 mb-2 w-6 h-6 rounded-full transition transform duration-100 ease-linear cursor-pointer"
                    :class="[toggle === '1' ? 'translate-x-full border-sky-400' : 'translate-x-0 border-gray-400']"></label>
                <input type="checkbox" id="toggle" name="toggle"
                    class="appearance-none w-full h-full active:outline-none focus:outline-none"
                    @click="toggle === '0' ? toggle = '1' : toggle = '0'"
                    wire:model.live='destination_form.requires_visa' />
            </div>
            <p>نیاز به تهیه ویزا <span x-text="toggle === '1' ? 'دارد' : 'ندارد'"></span></p>
        </div>
        @if ($destination_form->requires_visa)
        <div class="min-w-96 relative">
            <span class="absolute -top-2 right-2 text-xs py-1 px-2 rounded-full bg-white">زمان مورد نیاز برای
                اخذ
                ویزا
                (روز) *</span>
            <input type="number" wire:model='destination_form.visa_preparation_days'
                class="w-full h-full shadow-sm border border-black/10 py-3 px-4 rounded-md">
        </div>
        @endif
        <div class="flex flex-col">
            <hr class="opacity-70 mb-3">
            <button class="border border-gray-700 py-1 px-3 rounded-md shadow-md" type="submit">ذخیره</button>
        </div>
    </form>
</dialog>