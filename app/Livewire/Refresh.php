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
    public $averageFromProviders;
    public $ath;
    public $athDate;
    public $fromATHDate;
    public $averageFromProvidersUSD;
    public $athPercentage;
    public $exchangeRate;
    

    public function render()
    {
        $this->total_num = DB::table('forge.variables')->where('variables.name', 'total_num')->first()->valuesint;
        if($this->total_num == 0){
            $this->averageFromProviders = 0;
        }
        else{
            $this->providers['coinmarketcap'] = DB::table('forge.variables')->where('variables.name', 'coinmarketcap')->first()->valueseur;
            $this->providers['blockchain'] = DB::table('forge.variables')->where('variables.name', 'blockchain')->first()->valueseur;
            $this->providers['coindesk'] = DB::table('forge.variables')->where('variables.name', 'coindesk')->first()->valueseur;
            $this->providers['bitstamp'] = DB::table('forge.variables')->where('variables.name', 'bitstamp')->first()->valueseur;
            $this->providers['peachbitcoin'] = DB::table('forge.variables')->where('variables.name', 'peachbitcoin')->first()->valueseur;
            $this->providers['coinbase'] = DB::table('forge.variables')->where('variables.name', 'coinbase')->first()->valueseur;
            
    
            $this->ath = DB::table('forge.variables')->where('variables.name', 'ATH')->first()->valueseur;
            $this->athDate = DB::table('forge.variables')->where('variables.name', 'ATH')->first()->date;
            $this->fromATHDate = Carbon::create($this->athDate)->diffForHumans(['parts' => 3, 'join' => true,]);
    
            $this->averageFromProviders = DB::table('forge.variables')->where('variables.name', 'average')->first()->valueseur;
            
            $this->exchangeRate = DB::table('forge.variables')->where('variables.name', 'exchangeRate')->first()->valuesbtc;
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
        }

        return view('livewire.refresh');
    }

    
}
