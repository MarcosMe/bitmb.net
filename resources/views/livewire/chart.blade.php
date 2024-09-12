<div class="relative isolate overflow-hidden bg-gray-900" x-data="{ 
        
        init() {
            

            const labels = $wire.chartDataTimes;
            const data = {
                labels: labels,
                datasets: [{
                    label: `${$wire.chart}`,
                    data: $wire.chartDataValues,
                    borderWidth: 1,
                    pointRadius: 0,
                    lineTension: 0.4
                }]
            };
             const config = {
                 type: 'line',
                 data: data,
                 options: {
                    showLines: true,
                    spanGaps: true,
                    animations: {
                        tension: {
                            duration: 1000,
                            easing: 'linear',
                            from: 1,
                            to: 0,
                            loop: true
                        }
                    },
                    scales: {
                        y: {
                                ticks: {
                                    beginAtZero:false,
                                    callback: function(value, index, values) {
                                        return value + ' €';
                                    }
                                }
                            },
                            x: {
                                ticks: {
                                // For a category axis, the val is the index so the lookup via getLabelForValue is needed
                                    callback: function(val, index) {
                                    // Hide every 2nd tick label
                                        return index % 2 === 0 ? this.getLabelForValue(val).slice(5,16) : '';
                                    },
                                }
                            }
                    },
                       
                 }
             };
              myChart = new Chart(
                 this.$refs.canvas,
                 config
             );


            Livewire.on('updateTheChart', () => {
                myChart.data.labels = $wire.chartDataTimes;
                myChart.data.datasets[0].data = $wire.chartDataValues;
                myChart.data.datasets[0].label = `${$wire.chart}`;
                myChart.update();
            })


        }

        
    }">
    <div class="px-6 py-6 sm:px-6 sm:py-12 lg:px-8">
    <div class="mx-auto max-w-3xl text-center">
        <div class="inline-block">
            <label for="chart" class="block text-sm font-medium leading-6 text-white">Charts</label>
        
            <select name="chart" id="chart" wire:model="chart" wire:change="updateChart"
            class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                @foreach ($possibleCharts as $chart)
                    <option value="{{ $chart }}">{{ $chart }}</option>
                @endforeach
            </select>
        </div>    
        <div>
        Selected: <span x-text="$wire.chart"></span>
        </div>
        <canvas id="myChart" x-ref="canvas"></canvas>
        
    </div>
    </div>
</div>
