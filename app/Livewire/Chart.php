<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Chart extends Component
{

    public $chartDataTimes;
    public $chartDataValues;
    public $chart;

    public function mount()
    {
        $this->chart = 'Day';
    }

    public function updateChart()
    {
        $this->dispatch('updateTheChart');
    }
    public function render()
    {
        switch($this->chart){
            case 'Day':
                $this->chartDataTimes =  DB::table('chart_day')->whereNotNull('Value')->orderBy('Date', 'asc')->pluck('Date');
                $this->chartDataValues =  DB::table('chart_day')->whereNotNull('Value')->orderBy('Date', 'asc')->pluck('Value');
                break;
            case 'Week':
                $this->chartDataTimes =  DB::table('chart_week')->whereNotNull('Value')->orderBy('Date', 'asc')->pluck('Date');
                $this->chartDataValues =  DB::table('chart_week')->whereNotNull('Value')->orderBy('Date', 'asc')->pluck('Value');
                break;
            case 'Month':
                $this->chartDataTimes =  DB::table('chart_month')->whereNotNull('Value')->orderBy('Date', 'asc')->pluck('Date');
                $this->chartDataValues =  DB::table('chart_month')->whereNotNull('Value')->orderBy('Date', 'asc')->pluck('Value');
                break;
            case 'Year':
                $this->chartDataTimes =  DB::table('chart_year')->whereNotNull('Value')->orderBy('Date', 'asc')->pluck('Date');
                $this->chartDataValues =  DB::table('chart_year')->whereNotNull('Value')->orderBy('Date', 'asc')->pluck('Value');
                break;

            default:
                $this->chartDataTimes =  DB::table('chart_day')->whereNotNull('Value')->orderBy('Date', 'asc')->pluck('Date');
                $this->chartDataValues =  DB::table('chart_day')->whereNotNull('Value')->orderBy('Date', 'asc')->pluck('Value');
        }

        $possibleCharts = [
            'Day', 'Week', 'Month', 'Year'
        ];

        return view('livewire.chart', [
            'possibleCharts' => $possibleCharts,
        ]);
    }
}
