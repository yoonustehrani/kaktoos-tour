<div class="container mx-auto mt-10" dir="rtl">
    <div class="wrapper bg-white rounded shadow w-full" dir="ltr">
        <div class="header flex justify-between border-b p-2">
            <span class="text-lg font-bold">
                {{ $this->getMonthName() }}
                <br>
                <span class="text-sm font-medium">
                    <input id="gregorian" type="checkbox" wire:model.live='gregorian'>
                    <label for="gregorian">میلادی</label>
                </span>
            </span>
            <div dir="ltr" class="flex">
                <button wire:click='prevMonth' class="p-1">
                    <svg width="1em" fill="gray" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-left-circle"
                        fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path fill-rule="evenodd"
                            d="M8.354 11.354a.5.5 0 0 0 0-.708L5.707 8l2.647-2.646a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708 0z" />
                        <path fill-rule="evenodd" d="M11.5 8a.5.5 0 0 0-.5-.5H6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 .5-.5z" />
                    </svg>
                </button>
                <button wire:click='nextMonth' class="p-1">
                    <svg width="1em" fill="gray" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-right-circle"
                        fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path fill-rule="evenodd"
                            d="M7.646 11.354a.5.5 0 0 1 0-.708L10.293 8 7.646 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0z" />
                        <path fill-rule="evenodd" d="M4.5 8a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5z" />
                    </svg>
                </button>
            </div>
        </div>
        <table class="w-full" dir="rtl">
            <thead>
                <tr>
                    @foreach ($weekdays as $name => $short_name)
                        <th class="p-2 border-r h-10 xl:w-40 lg:w-30 md:w-30 sm:w-20 w-10 xl:text-sm text-xs">
                            <span class="xl:block lg:block md:block sm:block hidden">@lang($name)</span>
                            <span class="xl:hidden lg:hidden md:hidden sm:hidden block">{{ $short_name }}</span>
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($calendar as $week)
                    <tr class="text-center h-20">
                        @foreach ($week as $day)
                            <td
                                class="border {{ $day['isCurrentMonth'] ? 'cursor-pointer' : 'bg-gray-100 cursor-auto' }} p-1 h-40 xl:w-40 lg:w-30 md:w-30 sm:w-20 w-10 overflow-auto transition duration-500 ease hover:bg-gray-300">
                                @php
                                    $off = in_array(true, array_map(fn($x) => $x['is_off'], $day['events']));
                                @endphp
                                <div class="flex flex-col h-40 xl:w-40 lg:w-30 md:w-30 sm:w-full w-10 mx-auto overflow-hidden">
                                    <div class="top h-5 w-full">
                                        <span class="{{ $off ? 'text-red-500' : 'text-gray-500' }}">{{ $gregorian ? $day['date']->day : $day['date']->getDay() }}</span>
                                    </div>
                                    <div class="bottom flex-grow h-30 py-1 w-full">
                                        @foreach ($day['events'] as $event)
                                            <p class="text-xs text-right {{ $event['is_off'] ? 'text-red-500' : 'text-gray-400' }}">- {{ $event['event_name'] }} {{ $event['is_off'] ? '(تعطیل)' : '' }}</p>
                                        @endforeach
                                    </div>
                                </div>
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>