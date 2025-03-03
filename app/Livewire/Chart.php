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
        $this->updateChart();
    }

    public function updateChart()
    {
        switch($this->chart){
            case 'Day':
                $this->chartDataTimes =  DB::table('forge.chart_day')->whereNotNull('value')->orderBy('date', 'asc')->pluck('date');
                $this->chartDataValues =  DB::table('forge.chart_day')->whereNotNull('value')->orderBy('date', 'asc')->pluck('value');
                break;
            case 'Week':
                $this->chartDataTimes =  DB::table('forge.chart_week')->whereNotNull('value')->orderBy('date', 'asc')->pluck('date');
                $this->chartDataValues =  DB::table('forge.chart_week')->whereNotNull('value')->orderBy('date', 'asc')->pluck('value');
                break;
            case 'Month':
                $this->chartDataTimes =  DB::table('forge.chart_month')->whereNotNull('value')->orderBy('date', 'asc')->pluck('date');
                $this->chartDataValues =  DB::table('forge.chart_month')->whereNotNull('value')->orderBy('date', 'asc')->pluck('value');
                break;
            case 'Year':
                $this->chartDataTimes =  DB::table('forge.chart_year')->whereNotNull('value')->orderBy('date', 'asc')->pluck('date');
                $this->chartDataValues =  DB::table('forge.chart_year')->whereNotNull('value')->orderBy('date', 'asc')->pluck('value');
                break;

            default:
                $this->chartDataTimes =  DB::table('forge.chart_day')->whereNotNull('value')->orderBy('date', 'asc')->pluck('date');
                $this->chartDataValues =  DB::table('forge.chart_day')->whereNotNull('value')->orderBy('date', 'asc')->pluck('value');
        }

        $this->dispatch('updateTheChart');
    }

    public function render()
    {
        
        //var_dump($this->chart);
        $possibleCharts = [
            'Day', 'Week', 'Month', 'Year'
        ];

        return view('livewire.chart', [
            'possibleCharts' => $possibleCharts,
        ]);
    }
}
