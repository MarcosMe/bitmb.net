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
        $this->total_num = DB::table('variables')->where('Name', 'total_num')->first()->ValuesINT;
        if($this->total_num == 0){
            $this->averageFromProviders = 0;
        }
        else{
            $this->providers['coinmarketcap'] = DB::table('variables')->where('Name', 'coinmarketcap')->first()->ValuesEUR;
            $this->providers['blockchain'] = DB::table('variables')->where('Name', 'blockchain')->first()->ValuesEUR;
            $this->providers['coindesk'] = DB::table('variables')->where('Name', 'coindesk')->first()->ValuesEUR;
            $this->providers['bitstamp'] = DB::table('variables')->where('Name', 'bitstamp')->first()->ValuesEUR;
            $this->providers['peachbitcoin'] = DB::table('variables')->where('Name', 'peachbitcoin')->first()->ValuesEUR;
            $this->providers['coinbase'] = DB::table('variables')->where('Name', 'coinbase')->first()->ValuesEUR;
            
    
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
        }

        return view('livewire.refresh');
    }

    
}
