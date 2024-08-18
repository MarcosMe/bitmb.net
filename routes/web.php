<?php

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    $total_num = 6;
    $total = 0;
    $providers = [ 
                [0,'https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/','latest?id=1&convert=EUR',['data','1','quote','EUR','price'],0], 
                [1,'https://blockchain.info/','ticker',['EUR','last'],0],
                [2,'https://api.coindesk.com/v1/bpi/currentprice/','USD',['bpi','USD','rate_float'],0], 
                [3,'https://www.bitstamp.net/api/v2/ticker/','btceur',['last'],0], 
                [4,'https://apiv2.bitcoinaverage.com/indices/global/ticker/','BTCEUR',['last'],0], 
                [5,'https://api.coinbase.com/v2/','prices/spot?currency=EUR',['data','amount'],0]];
                        
    $now = Carbon::now();
    $minute = ($now->minute) + ($now->hour * 60);
    $fiveMinutes = $minute % 5;
    foreach($providers as $key => $provider){
        try {
            if($provider[0] == 0){
                if($fiveMinutes == 0){
                    $client = new Client(['base_uri' => $provider[1], 'timeout'  => 2.0,
                    'headers' => ['X-CMC_PRO_API_KEY' => 'bf1715de-0a7c-4e92-9f8d-33d33e955d7a', 'Accept' => 'application/json']]); 
                    $response = $client->request('GET', $provider[2]);
                    $items = json_decode($response->getBody(), true);
                    $getPath = $items[$provider[3][0]][$provider[3][1]][$provider[3][2]][$provider[3][3]][$provider[3][4]];
                    
                    $providers[0][4] = (float)number_format($getPath, 2, '.', '');
                    DB::table('variables')->where('Name', 'coinmarketcap')->update(['ValuesEUR' => $providers[0][4]]);
                }
                else{
                    $providers[0][4] = DB::table('variables')->where('Name', 'coinmarketcap')->first()->ValuesEUR;
                    if($providers[0][4] == 0){
                        $total_num -= 1;
                    }
                    //$providers[0][4] = 0;
                    //DB::table('variables')->where('Name', 'coinmarketcap')->update(['ValuesEUR' => 0]);
                    //$total_num -= 1;
                    //Log::info('Value for coinmarketcap: '.$providers[0][4]);
                }
            }
            else{
                $client = new Client(['base_uri' => $provider[1], 'timeout'  => 2.0]); 
                $response = $client->request('GET', $provider[2]);
                $items = json_decode($response->getBody(), true);
                if($provider[0] == 1){
                    $getPath = $items[$provider[3][0]][$provider[3][1]];
                    $providers[1][4] = (float)number_format($getPath, 2, '.', '');
                    DB::table('variables')->where('Name', 'blockchain')->update(['ValuesEUR' => $providers[1][4]]);
                }
                if($provider[0] == 2){
                    $getPath = $items[$provider[3][0]][$provider[3][1]][$provider[3][2]];
                    $exchangeRate = DB::table('variables')->where('Name', 'exchangeRate')->first()->ValuesBTC;
                    $providers[2][4] = (float)number_format($getPath/$exchangeRate, 2, '.', '');
                    DB::table('variables')->where('Name', 'coindesk')->update(['ValuesEUR' => $providers[2][4]]);
                }
                if($provider[0] == 3){
                    $getPath = $items[$provider[3][0]];
                    $providers[3][4] = (float)number_format($getPath, 2, '.', '');
                    DB::table('variables')->where('Name', 'bitstamp')->update(['ValuesEUR' => $providers[3][4]]);
                }
                if($provider[0] == 4){
                    $getPath = $items[$provider[3][0]];
                    $providers[4][4] = (float)number_format($getPath, 2, '.', '');
                    DB::table('variables')->where('Name', 'bitcoinaverage')->update(['ValuesEUR' => $providers[4][4]]);
                }
                if($provider[0] == 5){
                    $getPath = $items[$provider[3][0]][$provider[3][1]];
                    $providers[5][4] = (float)number_format($getPath/$exchangeRate, 2, '.', '');
                    DB::table('variables')->where('Name', 'coinbase')->update(['ValuesEUR' => $providers[5][4]]);
                }
            }
            
            $total = $total + $providers[$key][4];
            //Log::info('Total: '.$total);
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            Log::info('CAUGHT EXCEPTION on provider '.$provider[0]);
            $provider[4] = 0;
            if($provider[0] == 0){
                DB::table('variables')->where('Name', 'coinmarketcap')->update(['ValuesEUR' => 0]);
            }
            if($provider[0] == 1){
                DB::table('variables')->where('Name', 'blockchain')->update(['ValuesEUR' => 0]);
            }
            if($provider[0] == 2){
                DB::table('variables')->where('Name', 'coindesk')->update(['ValuesEUR' => 0]);
            }
            if($provider[0] == 3){
                DB::table('variables')->where('Name', 'bitstamp')->update(['ValuesEUR' => 0]);
            }
            if($provider[0] == 4){
                DB::table('variables')->where('Name', 'bitcoinaverage')->update(['ValuesEUR' => 0]);
            }
            if($provider[0] == 5){
                DB::table('variables')->where('Name', 'coinbase')->update(['ValuesEUR' => 0]);
            }
            $total_num -= 1;
            //dd("entrou1");
        }

        catch (\Exception $e) {
            Log::info('CAUGHT EXCEPTION on provider '.$provider[0]);
            $provider[4] = 0;
            if($provider[0] == 0){
                DB::table('variables')->where('Name', 'coinmarketcap')->update(['ValuesEUR' => 0]);
            }
            if($provider[0] == 1){
                DB::table('variables')->where('Name', 'blockchain')->update(['ValuesEUR' => 0]);
            }
            if($provider[0] == 2){
                DB::table('variables')->where('Name', 'coindesk')->update(['ValuesEUR' => 0]);
            }
            if($provider[0] == 3){
                DB::table('variables')->where('Name', 'bitstamp')->update(['ValuesEUR' => 0]);
            }
            if($provider[0] == 4){
                DB::table('variables')->where('Name', 'bitcoinaverage')->update(['ValuesEUR' => 0]);
            }
            if($provider[0] == 5){
                DB::table('variables')->where('Name', 'coinbase')->update(['ValuesEUR' => 0]);
            }
            $total_num -= 1;
            //dd("entrou1");
        }
    }        
    DB::table('variables')->where('Name', 'total_num')->update(['ValuesINT' => $total_num]);
    if($total_num == 0){
        $average = 0;
        Log::info('Average value is 0! using previous average');
    }
    else{
        $average = number_format($total / $total_num , 2, '.', '');
        DB::table('variables')->where('Name', 'average')->update(['ValuesEUR' => $average]);
    }
    Log::info($average. ' average value from ' .$total_num. ' providers -> 0-' 
    .$providers[0][4].' 1-'. $providers[1][4].' 2-'. $providers[2][4].' 3-'. $providers[3][4].' 4-'. $providers[4][4].' 5-'.$providers[5][4]);

    $total_num = DB::table('variables')->where('Name', 'total_num')->first()->ValuesINT;

    if($total_num == 0){
        $averageFromProviders = 0;
    }
    else{
        $coinmarketcap = DB::table('variables')->where('Name', 'coinmarketcap')->first()->ValuesEUR;
        $blockchain = DB::table('variables')->where('Name', 'blockchain')->first()->ValuesEUR;
        $coindesk = DB::table('variables')->where('Name', 'coindesk')->first()->ValuesEUR;
        $bitstamp = DB::table('variables')->where('Name', 'bitstamp')->first()->ValuesEUR;
        $bitcoinaverage = DB::table('variables')->where('Name', 'bitcoinaverage')->first()->ValuesEUR;
        $coinbase = DB::table('variables')->where('Name', 'coinbase')->first()->ValuesEUR;
        

        $ath = DB::table('variables')->where('Name', 'ATH')->first()->ValuesEUR;
        $athDate = DB::table('variables')->where('Name', 'ATH')->first()->Date;
        $fromATHDate = Carbon::create($athDate)->diffForHumans(['parts' => 4, 'join' => true,]);

        $averageFromProviders = DB::table('variables')->where('Name', 'average')->first()->ValuesEUR;
        
        $exchange = DB::table('variables')->where('Name', 'exchangeRate')->first()->ValuesBTC;
        $exchange = number_format($exchange * $averageFromProviders, 2, '.', '');

        if($averageFromProviders != $ath){
            if(number_format(100 - (($averageFromProviders * 100) / (float)$ath), 1, '.', '') == 0.0 || 
                number_format(100 - (($averageFromProviders * 100) / (float)$ath), 0, '.', '') == 0 ||
                number_format(100 - (($averageFromProviders * 100) / (float)$ath), 0, '.', '') != 0
            ){
                $athPercentage = number_format(100 - (($averageFromProviders * 100) / (float)$ath), 2, '.', '');
            }
            if(number_format(100 - (($averageFromProviders * 100) / (float)$ath), 2, '.', '') == 0.00){
                $athPercentage = number_format(100 - (($averageFromProviders * 100) / (float)$ath), 3, '.', '');
            }
            if(number_format(100 - (($averageFromProviders * 100) / (float)$ath), 3, '.', '') == 0.000){
                $athPercentage = number_format(100 - (($averageFromProviders * 100) / (float)$ath), 4, '.', '');
            }
            if(number_format(100 - (($averageFromProviders * 100) / (float)$ath), 4, '.', '') == 0.0000){
                $athPercentage = number_format(100 - (($averageFromProviders * 100) / (float)$ath), 5, '.', '');
            }    
        }
        else{
            $athPercentage = 0;
        }

        //$coinmarketcap, $blockchain, $coindesk, $bitstamp,$bitcoinaverage, $coinbase, $averageFromProviders, $convertedTEB, $convertedTBE, $ath, $athDate, $athPercentage, $fromATHDate, $exchange]);
    }    

    //dd($averageFromProviders);
    return view('welcome', compact('coinmarketcap', 'blockchain', 'coindesk', 'bitstamp','bitcoinaverage', 'coinbase', 'averageFromProviders', 'ath', 'athDate', 'athPercentage', 'fromATHDate'));
});
