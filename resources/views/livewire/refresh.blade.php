<div wire:poll.60s>
    <div class="relative isolate overflow-hidden bg-gray-900" x-data="{ eurValue: $wire.entangle('averageFromProviders'), usdValue: $wire.entangle('averageFromProvidersUSD'), isEUR: true }">
        <div class="px-6 py-24 sm:px-6 sm:py-32 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
            <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                1 <i class="fa-solid fa-bitcoin-sign"></i> = <span @click="isEUR = !isEUR" class="cursor-pointer">
                <i class="fa-solid fa-dollar-sign" x-show="!isEUR"></i>
                <span x-text="isEUR ? eurValue : usdValue"></span> 
                <i class="fa-solid fa-euro-sign" x-show="isEUR"></i></span>
                
                <br>
                {{$averageFromProviders}} - {{$averageFromProvidersUSD}}
            </h2>
            <p class="mx-auto mt-6 max-w-xl text-lg leading-8 text-gray-300">Coming from {{$total_num}} providers</p>
                <ul role="list" class="mt-3 grid grid-cols-1 gap-2 sm:grid-cols-2 sm:gap-6 lg:grid-cols-6">
                    @foreach ($providers as $key => $provider)
                    <li class="col-span-1 flex rounded-md shadow-sm">
                        <div class="flex flex-1 items-center justify-between truncate">
                            <div class="flex-1 truncate px-4 py-2 text-sm">
                            <h3 class="font-medium text-white">{{$key}}</h3>
                            @if ($provider != 0)
                                <span class="inline-flex items-center gap-x-1.5 rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-700">
                                    <svg class="h-1.5 w-1.5 fill-green-500" viewBox="0 0 6 6" aria-hidden="true">
                                        <circle cx="3" cy="3" r="3" />
                                    </svg>
                                    {{$provider}}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-x-1.5 rounded-full bg-yellow-100 px-2 py-1 text-xs font-medium text-yellow-800">
                                    <svg class="h-1.5 w-1.5 fill-yellow-500" viewBox="0 0 6 6" aria-hidden="true">
                                        <circle cx="3" cy="3" r="3" />
                                    </svg>
                                    {{$provider}}
                                </span>
                            @endif
                            
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>