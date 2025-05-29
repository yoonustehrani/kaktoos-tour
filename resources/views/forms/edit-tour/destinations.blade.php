<x-sidebar :tour='$tour_form->tour' />
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