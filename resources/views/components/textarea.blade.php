@props(['title', 'icon_class'])

<div>
    <h4 class="font-bold text-xl pb-4 flex items-center gap-2"><i class="h-5 fi fi-rs-{{ $icon_class }}"></i> {{ $title }}</h4>
    <div class="relative w-full flex flex-row-reverse justify-end items-center gap-1">
        <textarea {{ $attributes }} class="shadow-sm w-full border border-black/10 p-3 rounded-md resize-none" rows="6"></textarea>
    </div>
</div>