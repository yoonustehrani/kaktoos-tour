@props(['tour'])
<div class="w-fit px-4 flex-shrink h-full flex duration-1000 items-center justify-center border-l border-black/10">
    <div class="w-[23rem] h-fit flex flex-col bg-white border border-black/10 rounded-lg">
        <div class="w-full h-72 bg-gray-400 rounded-t-lg relative">
            <img src="{{ get_file_url($tour->image_src) }}" class="w-full h-full">
            <div class="absolute top-3 right-3 flex gap-2">
                <span class="rounded-md  pt-1 px-2 {{ $tour->is_inbound ? 'bg-purple-500' : 'bg-sky-500' }}">
                    تور {{ $tour->is_inbound ? __('inbound') : __('outbound') }}
                </span>
                <span
                    class="rounded-md pt-1 px-2 {{ $tour->payment_type === \App\Enums\TourPaymentType::FULL ? 'bg-green-500' : 'bg-yellow-500' }}">
                    {{ $tour->payment_type->getTitleFa() }}
                </span>
            </div>
            {{ $slot }}
        </div>
        <div class="px-3 py-4 flex flex-col justify-between gap-4 grow">
            <span class="font-bold text-2xl">{{ $tour->title }}</span>
            <hr class="opacity-90">
            <div class="flex items-center justify-between text-gray-500">
                @php
                $airline = App\Models\Airline::find($tour->airline_code);
                @endphp
                @if($airline)
                <span class="w-1/2 flex items-center gap-2">
                    <i class="h-5 fi fi-rs-plane"></i>
                    <span>{{ $airline->name_fa ?: $airline->name }}</span>
                </span>
                @endif
                <span class="w-1/2 flex items-center justify-end gap-2">
                    <span>{{ $tour->number_of_nights }} @lang('Nights')</span>
                    <i class="h-5 fi fi-rs-moon"></i>
                </span>
            </div>
        </div>
    </div>
</div>