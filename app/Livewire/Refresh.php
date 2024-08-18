<?php

namespace App\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class Refresh extends Component
{

    public $total_num;
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

    public function render()
    {
        $this->total_num = DB::table('variables')->where('Name', 'total_num')->first()->ValuesINT;
        if($this->total_num == 0){
            $this->averageFromProviders = 0;
        }
        else{
            $this->coinmarketcap = DB::table('variables')->where('Name', 'coinmarketcap')->first()->ValuesEUR;
            $this->blockchain = DB::table('variables')->where('Name', 'blockchain')->first()->ValuesEUR;
            $this->coindesk = DB::table('variables')->where('Name', 'coindesk')->first()->ValuesEUR;
            $this->bitstamp = DB::table('variables')->where('Name', 'bitstamp')->first()->ValuesEUR;
            $this->peachbitcoin = DB::table('variables')->where('Name', 'peachbitcoin')->first()->ValuesEUR;
            $this->coinbase = DB::table('variables')->where('Name', 'coinbase')->first()->ValuesEUR;
            
    
            $this->ath = DB::table('variables')->where('Name', 'ATH')->first()->ValuesEUR;
            $this->athDate = DB::table('variables')->where('Name', 'ATH')->first()->Date;
            $this->fromATHDate = Carbon::create($this->athDate)->diffForHumans(['parts' => 4, 'join' => true,]);
    
            $this->averageFromProviders = DB::table('variables')->where('Name', 'average')->first()->ValuesEUR;
            
            $exchangeRate = DB::table('variables')->where('Name', 'exchangeRate')->first()->ValuesBTC;
            $this->averageFromProvidersUSD = number_format($exchangeRate * $this->averageFromProviders, 2, '.', '');
    
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
    
            //$coinmarketcap, $blockchain, $coindesk, $bitstamp,$peachbitcoin, $coinbase, $averageFromProviders, $this->ath, $this->athDate, $this->athPercentage, $fromATHDate, $averageFromProvidersUSD]);
        }

        return view('livewire.refresh');
    }

    
}
