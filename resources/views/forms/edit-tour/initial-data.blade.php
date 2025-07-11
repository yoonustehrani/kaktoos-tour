<div class="w-full h-full flex flex-grow items-center justify-center duration-300">
    <form wire:submit="submitInitialData" class="w-[23rem] h-fit flex flex-col bg-white border border-black/10 rounded-lg">
        <div class="w-full h-72 bg-gray-400 rounded-t-lg hover:cursor-pointer relative"
            x-data="{ uploading: false, progress: 0 }"
            x-on:livewire-upload-start="uploading = true"
            x-on:livewire-upload-finish="uploading = false"
            x-on:livewire-upload-cancel="uploading = false"
            x-on:livewire-upload-error="uploading = false"
            x-on:livewire-upload-progress="progress = $event.detail.progress"
            x-on:click="document.getElementById('tour-file')?.click()"
            >
            @switch(true)
                @case($photo)
                    <img src="{{ $photo->temporaryUrl() }}" class="w-full h-full">
                    @break
                @case($tour_form->image_src)
                    <div class="w-full h-full flex flex-col items-center justify-center relative">
                        <img src="{{ get_file_url($tour_form->image_src) }}" class="w-full h-full">
                        <div class="w-full h-full bg-black/50 absolute flex flex-col items-center justify-center">
                            <i class="fi fi-rs-gallery text-4xl"></i>
                            <span>تغییر تصویر تور</span>
                        </div>
                    </div>
                    @break
                @default
                    <div class="w-full h-full flex flex-col items-center justify-center">
                        <i class="fi fi-rs-gallery text-4xl"></i>
                        <span>آپلود تصویر تور</span>
                    </div>
            @endswitch
            @error('photo')
                <div class="absolute h-auto bottom-0 left-0 w-full py-1 px-2 text-sm text-red-500 bg-red-300">
                    {{ $message }}
                </div>
            @enderror
            @error('tour_form.image_src')
                <div class="absolute h-auto bottom-0 left-0 w-full py-1 px-2 text-sm text-red-500 bg-red-300">
                    {{ $message }}
                </div>
            @enderror
            <!-- File Input -->
            <input type="file" id="tour-file" wire:model="photo" class="hidden">

            <!-- Progress Bar -->
            <div x-show="uploading">
                <progress max="100" x-bind:value="progress"></progress>
            </div>
        </div>
        <div class="px-3 py-4 flex flex-col justify-between gap-4 grow">
            <input wire:model='tour_form.title' @error('tour_form.title') aria-invalid="true" @enderror type="text" placeholder="عنوان تور را بنویسید" class="form-input w-full py-1 px-2 font-bold text-2xl">
            <div class="text-red-500">
                @error('tour_form.title') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="flex items-center justify-between gap-3 text-gray-500">
                <div class="grow flex items-center gap-2">
                    <livewire:airline-select 
                        :selectedId="$tour_form->airline_code ?? null"
                        placeholder="جستجوی ایرلاین ..."
                    />
                    <i class="h-5 fi fi-rs-plane"></i>
                </div>
                <div class="w-fit flex items-center justify-end gap-2">
                    <input type="number" wire:model='tour_form.number_of_nights' min="0" max="20" class="max-w-14 form-input w-full py-1 px-2"> 
                    <span class="flex items-center gap-2">
                        <span>@lang('Nights')</span>
                        <i class="h-5 fi fi-rs-moon"></i>
                    </span>
                </div>
            </div>
            @error('tour_form.airline_code')
            <div class="text-red-500">
                 <span class="error">{{ $message }}</span>
            </div>
            @enderror
            @error('tour_form.number_of_nights')
            <div class="text-red-500">
                <span class="error">{{ $message }}</span>
            </div>
            @enderror
            <div></div>
            <div class="flex justify-center">
                <button type="submit" class="px-3 duration-300 py-1 text-white bg-gray-700 rounded-full flex items-center gap-2 font-semibold">
                    ذخیره
                </button>
            </div>
        </div>
    </form>
</div>
<div class="flex-shrink w-0 duration-300 h-full"></div>
