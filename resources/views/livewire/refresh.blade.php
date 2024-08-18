<div wire:poll.60s>
    <div class="relative isolate overflow-hidden bg-gray-900" x-data="{ eurValue: $wire.entangle('averageFromProviders'), usdValue: $wire.entangle('averageFromProvidersUSD'), isEUR: true }">
        <div class="px-6 py-24 sm:px-6 sm:py-32 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
            <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                1 <i class="fa-solid fa-bitcoin-sign"></i> = <span @click="isEUR = !isEUR" class="cursor-pointer">
                <i class="fa-solid fa-dollar-sign" x-show="!isEUR"></i>
                <span x-text="isEUR ? eurValue : usdValue"></span> 
                <i class="fa-solid fa-euro-sign" x-show="isEUR"></i></span>
                
                <br>
                {{$averageFromProviders}} - {{$averageFromProvidersUSD}}
            </h2>
            <p class="mx-auto mt-6 max-w-xl text-lg leading-8 text-gray-300">Incididunt sint fugiat pariatur cupidatat consectetur sit cillum anim id veniam aliqua proident excepteur commodo do ea.</p>
            <div class="mt-10 flex items-center justify-center gap-x-6">
                <a href="#" class="rounded-md bg-white px-3.5 py-2.5 text-sm font-semibold text-gray-900 shadow-sm hover:bg-gray-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">Get started</a>
                <a href="#" class="text-sm font-semibold leading-6 text-white">Learn more <span aria-hidden="true">→</span></a>
            </div>
            </div>
        </div>
    </div>
</div>