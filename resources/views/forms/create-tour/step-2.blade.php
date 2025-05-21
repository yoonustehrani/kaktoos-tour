<div class="w-fit px-4 flex-shrink h-full flex duration-1000 items-center justify-center border-l border-black/10">
    <div class="w-[23rem] h-fit flex flex-col bg-white border border-black/10 rounded-lg">
        <div class="w-full h-72 bg-gray-400 rounded-t-lg relative">
            <img src="{{ asset('storage/' . $form->image_url) }}" class="w-full h-full">
            <div class="absolute top-3 right-3 flex gap-2">
                <span class="rounded-md  pt-1 px-2 {{ $form->is_inbound ? 'bg-purple-500' : 'bg-sky-500' }}">
                    تور {{ $form->is_inbound ? __('inbound') : __('outbound') }}
                </span>
                <span class="rounded-md pt-1 px-2 {{ $form->payment_type === \App\Enums\TourPaymentType::FULL ? 'bg-green-500' : 'bg-yellow-500' }}">
                    {{ $form->payment_type->getTitleFa() }}
                </span>
            </div>
        </div>
        <div class="px-3 py-4 flex flex-col justify-between gap-4 grow">
            <span class="font-bold text-2xl">{{ $form->title }}</span>
            <hr class="opacity-90">
            <div class="flex items-center justify-between text-gray-500">
                @php
                    $airline = App\Models\Airline::find($form->airline_code);
                @endphp
                @if($airline)
                    <span class="w-1/2 flex items-center gap-2">
                        <i class="h-5 fi fi-rs-plane"></i>
                        <span>{{ $airline->name_fa ?? $airline_name }}</span>
                    </span>
                @endif
                <span class="w-1/2 flex items-center justify-end gap-2">
                    <span>{{ $form->number_of_nights }} @lang('Nights')</span>
                    <i class="h-5 fi fi-rs-moon"></i>
                </span>
            </div>
        </div>
    </div>
</div>
<div class="w-auto h-full flex-grow bg-gray-100 duration-300">
    <div class="h-full w-full overflow-y-auto grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 p-8">
        <div>
            <h4 class="font-bold text-xl pb-4 flex items-center gap-2"><i class="h-5 fi fi-rs-text"></i>نوع تور</h4>
            <div role="radiogroup" class="mx-auto flex gap-4 justify-start">
                <div class="flex items-center">
                    <div class="bg-white dark:bg-gray-100 rounded-full w-4 h-4 flex flex-shrink-0 justify-center items-center relative">
                        <input id="inbound" value="1" wire:model.live="form.is_inbound" type="radio" name="tour_type" class="checkbox appearance-none focus:opacity-100 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 focus:outline-none border rounded-full border-gray-400 absolute cursor-pointer w-full h-full checked:border-none" />
                        <div class="check-icon hidden border-4 border-indigo-700 rounded-full w-full h-full z-1"></div>
                    </div>
                    <label for="inbound" class="mr-2 text-sm leading-4 font-normal text-gray-800 ">تور داخلی</label>
                </div>
                <div class="flex items-center ml-6">
                    <div class="bg-white dark:bg-gray-100 rounded-full w-4 h-4 flex flex-shrink-0 justify-center items-center relative">
                        <input id="outbound" value="0" wire:model.live="form.is_inbound" type="radio" name="tour_type" class="checkbox appearance-none focus:opacity-100 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 focus:outline-none border rounded-full border-gray-400 absolute cursor-pointer w-full h-full checked:border-none" />
                        <div class="check-icon hidden border-4 border-indigo-700 rounded-full w-full h-full z-1"></div>
                    </div>
                    <label for="outbound" class="mr-2 text-sm leading-4 font-normal text-gray-800 ">تور خارجی</label>
                </div>
                <style>
                    .checkbox:checked {
                        border: none;
                    }
                    .checkbox:checked + .check-icon {
                        display: flex;
                    }
                </style>
            </div>
        </div>
        <div>
            <h4 class="font-bold text-xl pb-4 flex items-center gap-2"><i class="h-5 fi fi-rs-dollar"></i>نوع پرداخت</h4>
            <div role="radiogroup" class="mx-auto flex gap-4 justify-start">
                <div class="flex items-center">
                    <div class="bg-white dark:bg-gray-100 rounded-full w-4 h-4 flex flex-shrink-0 justify-center items-center relative">
                        <input id="type-f" value="F" wire:model.live="form.payment_type" type="radio" name="payment_type" class="checkbox appearance-none focus:opacity-100 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 focus:outline-none border rounded-full border-gray-400 absolute cursor-pointer w-full h-full checked:border-none" />
                        <div class="check-icon hidden border-4 border-indigo-700 rounded-full w-full h-full z-1"></div>
                    </div>
                    <label for="type-f" class="mr-2 text-sm leading-4 font-normal text-gray-800 ">عادی</label>
                </div>
                <div class="flex items-center ml-6">
                    <div class="bg-white dark:bg-gray-100 rounded-full w-4 h-4 flex flex-shrink-0 justify-center items-center relative">
                        <input id="type-i" value="I" wire:model.live="form.payment_type" type="radio" name="payment_type" class="checkbox appearance-none focus:opacity-100 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 focus:outline-none border rounded-full border-gray-400 absolute cursor-pointer w-full h-full checked:border-none" />
                        <div class="check-icon hidden border-4 border-indigo-700 rounded-full w-full h-full z-1"></div>
                    </div>
                    <label for="type-i" class="mr-2 text-sm leading-4 font-normal text-gray-800 ">اقساطی</label>
                </div>
                <style>
                    .checkbox:checked {
                        border: none;
                    }
                    .checkbox:checked + .check-icon {
                        display: flex;
                    }
                </style>
            </div>
        </div>
        <div>
            <h4 class="font-bold text-xl pb-4 flex items-center gap-2"><i class="h-5 fi fi-rs-map-pin"></i>مبدا</h4>
            <div class="w-1/2 flex items-center gap-2">
                <livewire:origin-select 
                    :selectedId="$form->origin_id ?? null"
                    placeholder="جستجوی مبدا ..."
                />
            </div>
        </div>
    </div>
</div>
