<x-sidebar :tour='$form' />
<div class="w-auto h-full flex-grow bg-gray-100 duration-300">
    <div class="h-full max-h-full w-full overflow-y-auto gap-6 gap-y-8 place-content-start grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 p-8">
        <div>
            <h4 class="font-bold text-xl pb-4 flex items-center gap-2"><i class="h-5 fi fi-rs-text"></i>نوع تور</h4>
            <div role="radiogroup" class="mx-auto flex gap-4 justify-start">
                <div class="flex items-center">
                    <div
                        class="bg-white dark:bg-gray-100 rounded-full w-4 h-4 flex flex-shrink-0 justify-center items-center relative">
                        <input id="inbound" value="1" wire:model.live="form.is_inbound" type="radio" name="tour_type"
                            class="checkbox appearance-none focus:opacity-100 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 focus:outline-none border rounded-full border-gray-400 absolute cursor-pointer w-full h-full checked:border-none" />
                        <div class="check-icon hidden border-4 border-indigo-700 rounded-full w-full h-full z-1"></div>
                    </div>
                    <label for="inbound" class="mr-2 text-sm leading-4 font-normal text-gray-800 ">تور داخلی</label>
                </div>
                <div class="flex items-center ml-6">
                    <div
                        class="bg-white dark:bg-gray-100 rounded-full w-4 h-4 flex flex-shrink-0 justify-center items-center relative">
                        <input id="outbound" value="0" wire:model.live="form.is_inbound" type="radio" name="tour_type"
                            class="checkbox appearance-none focus:opacity-100 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 focus:outline-none border rounded-full border-gray-400 absolute cursor-pointer w-full h-full checked:border-none" />
                        <div class="check-icon hidden border-4 border-indigo-700 rounded-full w-full h-full z-1"></div>
                    </div>
                    <label for="outbound" class="mr-2 text-sm leading-4 font-normal text-gray-800 ">تور خارجی</label>
                </div>
                <style>
                    .checkbox:checked {
                        border: none;
                    }

                    .checkbox:checked+.check-icon {
                        display: flex;
                    }
                </style>
            </div>
        </div>
        <div>
            <h4 class="font-bold text-xl pb-4 flex items-center gap-2"><i class="h-5 fi fi-rs-dollar"></i>نوع پرداخت
            </h4>
            <div role="radiogroup" class="mx-auto flex gap-4 justify-start">
                <div class="flex items-center">
                    <div
                        class="bg-white dark:bg-gray-100 rounded-full w-4 h-4 flex flex-shrink-0 justify-center items-center relative">
                        <input id="type-f" value="F" wire:model.live="form.payment_type" type="radio"
                            name="payment_type"
                            class="checkbox appearance-none focus:opacity-100 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 focus:outline-none border rounded-full border-gray-400 absolute cursor-pointer w-full h-full checked:border-none" />
                        <div class="check-icon hidden border-4 border-indigo-700 rounded-full w-full h-full z-1"></div>
                    </div>
                    <label for="type-f" class="mr-2 text-sm leading-4 font-normal text-gray-800 ">عادی</label>
                </div>
                <div class="flex items-center ml-6">
                    <div
                        class="bg-white dark:bg-gray-100 rounded-full w-4 h-4 flex flex-shrink-0 justify-center items-center relative">
                        <input id="type-i" value="I" wire:model.live="form.payment_type" type="radio"
                            name="payment_type"
                            class="checkbox appearance-none focus:opacity-100 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 focus:outline-none border rounded-full border-gray-400 absolute cursor-pointer w-full h-full checked:border-none" />
                        <div class="check-icon hidden border-4 border-indigo-700 rounded-full w-full h-full z-1"></div>
                    </div>
                    <label for="type-i" class="mr-2 text-sm leading-4 font-normal text-gray-800 ">اقساطی</label>
                </div>
                <style>
                    .checkbox:checked {
                        border: none;
                    }

                    .checkbox:checked+.check-icon {
                        display: flex;
                    }
                </style>
            </div>
        </div>
        <div>
            <h4 class="font-bold text-xl pb-4 flex items-center gap-2"><i class="h-5 fi fi-rs-map-pin"></i>مبدا</h4>
            <div class="flex flex-col max-w-48 items-center gap-2">
                <livewire:location-select :selectedId="$form->origin_id ?? null" placeholder="جستجوی مبدا ..."
                    eventName="origin-item-selected" originMode />
                @error('form.origin_id')
                    <div class="text-red-500">
                        <span class="error">{{ $message }}</span>
                    </div>
                @enderror
            </div>
        </div>
        <x-textarea title="توضیحات تور" icon_class="comment" wire:model='form.description' placeholder="مسئولیت کنترل پاسپورت از جهت اعتبار و ..."/>
        <x-textarea title="قوانین استرداد" icon_class="book" wire:model='form.return_policy' placeholder="گارانتی و ..."/>
        <x-textarea title="مدارک لازم" icon_class="passport" wire:model='form.required_documents' placeholder="اصل پاسپورت - اصل شناسنامه - اصل کارت ملی"/>
        <x-textarea title="خدمات تور" icon_class="list" wire:model='form.services' placeholder="پرواز رفت و برگشت مستقیم ..."/>
        @if ($form->payment_type === \App\Enums\TourPaymentType::INSTALLMENT)
            <x-textarea title="شرایط اقساطی" icon_class="percentage" wire:model='form.installment_policy' placeholder="اقساط بین 1 تا 4 ماه - کارمزد 4% ..."/>
        @endif
        <div class="col-span-full flex items-center justify-center">
            <button wire:click='submit' class="px-3 duration-300 py-1 text-white bg-gray-700 rounded-full flex items-center gap-2 font-semibold">
                ادامه
                <span class="text-lg h-4 fi fi-rs-arrow-left"></span>
            </button>
        </div>
    </div>
</div>