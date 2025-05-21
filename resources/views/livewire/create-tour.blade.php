<main class="w-full h-full">
    <section class="w-full h-full flex">
        @include("forms.create-tour.step-$step")
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
                    {{-- <input type="text" class="w-full h-full shadow-sm border border-black/10 py-3 px-4 rounded-md">
                    --}}
                </div>
                <div class="min-w-96 relative flex">
                    <span class="absolute -top-2 right-2 text-xs py-1 px-2 rounded-full bg-white">تعداد شب ها *</span>
                    <input type="number" wire:model='destination_form.number_of_nights'
                        class="w-full h-full shadow-sm border border-black/10 py-3 px-4 rounded-md">
                </div>
                {{-- <div class="flex items-center gap-2"
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
                @endif --}}
                <div class="flex flex-col">
                    <hr class="opacity-70 mb-3">
                    <button class="border border-gray-700 py-1 px-3 rounded-md shadow-md" type="submit">ذخیره</button>
                </div>
            </form>
        </dialog>
    </section>
    <div class="text-lg fixed bottom-5 left-5 flex gap-4">
        <p class="px-3 py-1 bg-white shadow-sm border border-black/10 rounded-lg">@lang('Step') {{ $step }}:
            @lang($steps[$step - 1])</p>
        <button wire:click='decrementStep' @disabled($step < 2)
            class="size-10 z-50 bg-white shadow-sm border border-black/10 rounded-lg flex items-center justify-center"
            type="button"><i class="fi size-6 fi-rs-arrow-right"></i></button>
        <button wire:click='incrementStep'
            class="size-10 z-50 bg-white shadow-sm border border-black/10 rounded-lg flex items-center justify-center"
            type="button"><i class="fi size-6 fi-rs-arrow-left"></i></button>
    </div>
</main>