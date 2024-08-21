<?php

namespace App\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class Refresh extends Component
{

    public $total_num;
    public array $providers = [];
    public $coinmarketcap;
    public $blockchain;
    public $coindesk;
    public $bitstamp;
    public $peachbitcoin;
    public $coinbase;
    public $averageFromProviders;
    public $ath;
    public $athDate;
    public $fromATHDate;
    public $averageFromProvidersUSD;
    public $athPercentage;
    public $exchangeRate;
    public $chartDataMinute;
    public $chartDataValue;

    public function render()
    {
        $this->total_num = DB::table('variables')->where('Name', 'total_num')->first()->ValuesINT;
        if($this->total_num == 0){
            $this->averageFromProviders = 0;
        }
        else{
            $this->coinmarketcap = DB::table('variables')->where('Name', 'coinmarketcap')->first()->ValuesEUR;
            $this->providers['coinmarketcap'] = $this->coinmarketcap;
            $this->blockchain = DB::table('variables')->where('Name', 'blockchain')->first()->ValuesEUR;
            $this->providers['blockchain'] = $this->blockchain;
            $this->coindesk = DB::table('variables')->where('Name', 'coindesk')->first()->ValuesEUR;
            $this->providers['coindesk'] = $this->coindesk;
            $this->bitstamp = DB::table('variables')->where('Name', 'bitstamp')->first()->ValuesEUR;
            $this->providers['bitstamp'] = $this->bitstamp;
            $this->peachbitcoin = DB::table('variables')->where('Name', 'peachbitcoin')->first()->ValuesEUR;
            $this->providers['peachbitcoin'] = $this->peachbitcoin;
            $this->coinbase = DB::table('variables')->where('Name', 'coinbase')->first()->ValuesEUR;
            $this->providers['coinbase'] = $this->coinbase;
            
    
            $this->ath = DB::table('variables')->where('Name', 'ATH')->first()->ValuesEUR;
            $this->athDate = DB::table('variables')->where('Name', 'ATH')->first()->Date;
            $this->fromATHDate = Carbon::create($this->athDate)->diffForHumans(['parts' => 3, 'join' => true,]);
    
            $this->averageFromProviders = DB::table('variables')->where('Name', 'average')->first()->ValuesEUR;
            
            $this->exchangeRate = DB::table('variables')->where('Name', 'exchangeRate')->first()->ValuesBTC;
            $this->averageFromProvidersUSD = number_format($this->exchangeRate * $this->averageFromProviders, 2, '.', '');
    
            if($this->averageFromProviders != $this->ath){
                if(number_format(100 - (($this->averageFromProviders * 100) / (float)$this->ath), 1, '.', '') == 0.0 || 
                    number_format(100 - (($this->averageFromProviders * 100) / (float)$this->ath), 0, '.', '') == 0 ||
                    number_format(100 - (($this->averageFromProviders * 100) / (float)$this->ath), 0, '.', '') != 0
                ){
                    $this->athPercentage = number_format(100 - (($this->averageFromProviders * 100) / (float)$this->ath), 2, '.', '');
                }
                if(number_format(100 - (($this->averageFromProviders * 100) / (float)$this->ath), 2, '.', '') == 0.00){
                    $this->athPercentage = number_format(100 - (($this->averageFromProviders * 100) / (float)$this->ath), 3, '.', '');
                }
                if(number_format(100 - (($this->averageFromProviders * 100) / (float)$this->ath), 3, '.', '') == 0.000){
                    $this->athPercentage = number_format(100 - (($this->averageFromProviders * 100) / (float)$this->ath), 4, '.', '');
                }
                if(number_format(100 - (($this->averageFromProviders * 100) / (float)$this->ath), 4, '.', '') == 0.0000){
                    $this->athPercentage = number_format(100 - (($this->averageFromProviders * 100) / (float)$this->ath), 5, '.', '');
                }    
            }
            else{
                $this->athPercentage = 0;
            }
            //dd($this->providers);
            //$coinmarketcap, $blockchain, $coindesk, $bitstamp,$peachbitcoin, $coinbase, $averageFromProviders, $this->ath, $this->athDate, $this->athPercentage, $fromATHDate, $averageFromProvidersUSD]);
        
            $this->chartDataMinute =  DB::table('chart_day')->whereNotNull('Value')->orderBy('Date', 'asc')->pluck('Date');
            $this->chartDataValue =  DB::table('chart_day')->whereNotNull('Value')->orderBy('Date', 'asc')->pluck('Value');
        
        }

        return view('livewire.refresh');
    }

    
}
