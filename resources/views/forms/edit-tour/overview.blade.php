<x-sidebar :tour='$tour_form->tour'>
    <div class="absolute top-3 left-3 flex gap-2">
    <a class="p-2 rounded-md shadow-sm text-gray-200 bg-gray-900" href="{{ route('tours.edit', ['tour' => $tour_form->tour->id, 'section' => 'initial-data']) }}" wire:navigate><i class="block size-4 fi fi-rs-pencil"></i></a>
    </div>
</x-sidebar>
<div class="w-auto h-full flex-grow bg-gray-100 duration-300">
    <section class="grid grid-cols-2 place-content-center place-items-center gap-8 w-fit h-full mx-auto">
        <a wire:navigate href="{{ route('tours.edit', ['tour' => $tour_form->tour->id, 'section' => 'destinations']) }}" class="flex flex-col items-center justify-center gap-6 min-w-96 max-w-96 bg-white shadow-md rounded-xl border border-black/10 h-64">
            <img class="size-24" src="{{ asset('icons/003-destination-2.svg') }}" height="100px" width="100px" alt="">
            <span class="text-3xl font-bold text-gray-700">مدیریت مقصد‌ها</span>
        </a>
        <a wire:navigate href="{{ route('tours.edit', ['tour' => $tour_form->tour->id, 'section' => 'destinations']) }}" class="flex flex-col items-center justify-center gap-6 min-w-96 max-w-96 bg-white shadow-md rounded-xl border border-black/10 h-64">
            <img class="size-24" src="{{ asset('icons/007-calendar.svg') }}" height="100px" width="100px" alt="">
            <span class="text-3xl font-bold text-gray-700">زمانبندی سفر</span>
        </a>
        <a wire:navigate href="{{ route('tours.edit', ['tour' => $tour_form->tour->id, 'section' => 'meta-data']) }}" class="flex flex-col items-center justify-center gap-6 min-w-96 max-w-96 bg-white shadow-md rounded-xl border border-black/10 h-64">
            <img class="size-24" src="{{ asset('icons/011-catalogue-1.svg') }}" height="100px" width="100px" alt="">
            <span class="text-3xl font-bold text-gray-700">جزئیات و توضیحات</span>
        </a>
        <a wire:navigate href="{{ route('tours.edit', ['tour' => $tour_form->tour->id, 'section' => 'page-config']) }}" class="flex flex-col items-center justify-center gap-6 min-w-96 max-w-96 bg-white shadow-md rounded-xl border border-black/10 h-64">
            <img class="size-24" src="{{ asset('icons/016-internet.svg') }}" height="100px" width="100px" alt="">
            <span class="text-3xl font-bold text-gray-700">مدیریت صفحه در وب‌سایت</span>
        </a>
    </section>
</div>