<main class="w-full h-full">
    <section class="w-full h-full flex">
        @include("forms.create-tour.step-$step")
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
