@include('forms.create-tour.sidebar')
<div class="w-auto h-full flex-grow bg-gray-100 duration-300">
    <div class="h-full max-h-full w-full overflow-y-auto gap-6 gap-y-8 place-content-start grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 p-8">
        <div>
            <h4 class="font-bold text-xl pb-4 flex items-center gap-2"><i class="h-5 fi fi-rs-clock"></i> تاریخ و ساعت انتشار</h4>
            <div class="relative max-w-96 flex flex-row-reverse justify-end items-center gap-1">
                <input type="date" wire:model='destination_form.number_of_nights'
                    class="h-full shadow-sm border border-black/10 py-1 px-1 rounded-md text-left" 
                    value="{{ $form->published_at->format('Y-m-d') }}"
                    @change.debounce.500ms='$wire.changePublishedAtDate($el.value)'
                    dir="ltr">
                <input type="time" wire:model='destination_form.number_of_nights'
                    class="h-full shadow-sm border border-black/10 py-1 px-1 rounded-md text-left" 
                    value="{{ $form->published_at->format('H:i') }}"
                    @change.debounce.500ms='$wire.changePublishedAtTime($el.value)'
                    dir="ltr">
            </div>
        </div>
        <div>
            <h4 class="font-bold text-xl pb-4 flex items-center gap-2"><i class="h-5 fi fi-rs-link"></i> لینک یکتای صفحه</h4>
            <div class="relative max-w-96 flex flex-row-reverse items-center gap-1">
                <p class="text-lg" dir="ltr">{{ config('app.url') }}/</p>
                <input type="text" wire:model='destination_form.number_of_nights'
                    class="h-full grow shadow-sm border border-black/10 py-1 px-1 rounded-md text-left" wire:model.live.debounce250ms='form.slug' dir="ltr">
            </div>
        </div>
    </div>
</div>