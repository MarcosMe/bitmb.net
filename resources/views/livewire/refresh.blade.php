<div wire:poll.60s>
    <div class="px-6 pt-24 sm:px-6 sm:pt-32 lg:px-8" x-data="{ eurValue: $wire.entangle('averageFromProviders'), usdValue: $wire.entangle('averageFromProvidersUSD'), isEUR: true }">
        <div class="mx-auto max-w-3xl text-center">
        <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl mb-2">
            1 <i class="fa-solid fa-bitcoin-sign"></i> = <span @click="isEUR = !isEUR" class="cursor-pointer">
            <span x-text="isEUR ? eurValue + '€' : '$' + usdValue"></span> 
        </span>
        </h2>
        <h3 class="font-medium text-white">
        {{$athPercentage}}% from all time high of 
            <span x-text="isEUR ? {{$ath}} + '€' : '$' + {{round($ath * $exchangeRate, 2)}}"></span> 
            <br>
            Achieved on {{$athDate}} ({{$fromATHDate}})
        </h3>
        <p class="mx-auto mt-8 max-w-xl text-lg leading-8 text-gray-300">Value coming from {{$total_num}} providers:</p>
            <ul role="list" class="mt-1 grid grid-cols-2 gap-2 sm:grid-cols-3 sm:gap-6 lg:grid-cols-6">
                @foreach ($providers as $key => $provider)
                <li class="col-span-1 flex rounded-md shadow-sm">
                    <div class="flex flex-1 items-center justify-between truncate">
                        <div class="flex-1 items-center px-4 text-sm">
                        <h3 class="font-medium text-white">{{$key}}</h3>
                        @if ($provider != 0)
                            <span class="inline-flex items-center gap-x-1.5 rounded-full bg-green-100 px-2 py-1 text-xs font-bold text-green-700">
                                <svg class="h-1.5 w-1.5 fill-green-500" viewBox="0 0 6 6" aria-hidden="true">
                                    <circle cx="3" cy="3" r="3" />
                                </svg>
                                
                                    <span x-text="isEUR ? {{$provider}} + '€' : '$' + {{round($provider * $exchangeRate, 2)}}"></span> 
                            </span>
                        @else
                            <span class="inline-flex items-center gap-x-1.5 rounded-full bg-yellow-100 px-2 py-1 text-xs font-medium text-yellow-800">
                                <svg class="h-1.5 w-1.5 fill-yellow-500" viewBox="0 0 6 6" aria-hidden="true">
                                    <circle cx="3" cy="3" r="3" />
                                </svg>
                                No data
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