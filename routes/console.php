<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schedule;
use Carbon\Carbon;
use GuzzleHttp\Client;

Schedule::call(function () {
    $total_num = 6;
    $total = 0;
    $providers = [ 
                [0,'https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/','latest?id=1&convert=EUR',['data','1','quote','EUR','price'],0], 
                [1,'https://blockchain.info/','ticker',['EUR','last'],0],
                [2,'https://api.coindesk.com/v1/bpi/currentprice/','USD',['bpi','USD','rate_float'],0], 
                [3,'https://www.bitstamp.net/api/v2/ticker/','btceur',['last'],0], 
                [4,'https://api.peachbitcoin.com/v1/market/price/','BTCEUR',['price'],0], 
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
                    DB::table('forge.variables')->where('variables.name', 'coinmarketcap')->update(['valueseur' => $providers[0][4]]);
                }
                else{
                    $providers[0][4] = DB::table('forge.variables')->where('variables.name', 'coinmarketcap')->first()->valueseur;
                    if($providers[0][4] == 0){
                        $total_num -= 1;
                    }
                    //$providers[0][4] = 0;
                    //DB::table('forge.variables')->where('variables.name', 'coinmarketcap')->update(['valueseur' => 0]);
                    //$total_num -= 1;
                    //Log::info('value for coinmarketcap: '.$providers[0][4]);
                }
            }
            else{
                $client = new Client(['base_uri' => $provider[1], 'timeout'  => 2.0]); 
                $response = $client->request('GET', $provider[2]);
                $items = json_decode($response->getBody(), true);
                if($provider[0] == 1){
                    $getPath = $items[$provider[3][0]][$provider[3][1]];
                    $providers[1][4] = (float)number_format($getPath, 2, '.', '');
                    DB::table('forge.variables')->where('variables.name', 'blockchain')->update(['valueseur' => $providers[1][4]]);
                }
                if($provider[0] == 2){
                    $getPath = $items[$provider[3][0]][$provider[3][1]][$provider[3][2]];
                    $exchangeRate = DB::table('forge.variables')->where('variables.name', 'exchangeRate')->first()->valuesBTC;
                    $providers[2][4] = (float)number_format($getPath/$exchangeRate, 2, '.', '');
                    DB::table('forge.variables')->where('variables.name', 'coindesk')->update(['valueseur' => $providers[2][4]]);
                }
                if($provider[0] == 3){
                    $getPath = $items[$provider[3][0]];
                    $providers[3][4] = (float)number_format($getPath, 2, '.', '');
                    DB::table('forge.variables')->where('variables.name', 'bitstamp')->update(['valueseur' => $providers[3][4]]);
                }
                if($provider[0] == 4){
                    $getPath = $items[$provider[3][0]];
                    $providers[4][4] = (float)number_format($getPath, 2, '.', '');
                    DB::table('forge.variables')->where('variables.name', 'peachbitcoin')->update(['valueseur' => $providers[4][4]]);
                }
                if($provider[0] == 5){
                    $getPath = $items[$provider[3][0]][$provider[3][1]];
                    $exchangeRate = DB::table('forge.variables')->where('variables.name', 'exchangeRate')->first()->valuesBTC;
                    $providers[5][4] = (float)number_format($getPath/$exchangeRate, 2, '.', '');
                    DB::table('forge.variables')->where('variables.name', 'coinbase')->update(['valueseur' => $providers[5][4]]);
                }
            }
            
            $total = $total + $providers[$key][4];
            //Log::info('Total: '.$total);
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            Log::info('CAUGHT EXCEPTION on provider '.$provider[0]);
            $provider[4] = 0;
            if($provider[0] == 0){
                DB::table('forge.variables')->where('variables.name', 'coinmarketcap')->update(['valueseur' => 0]);
            }
            if($provider[0] == 1){
                DB::table('forge.variables')->where('variables.name', 'blockchain')->update(['valueseur' => 0]);
            }
            if($provider[0] == 2){
                DB::table('forge.variables')->where('variables.name', 'coindesk')->update(['valueseur' => 0]);
            }
            if($provider[0] == 3){
                DB::table('forge.variables')->where('variables.name', 'bitstamp')->update(['valueseur' => 0]);
            }
            if($provider[0] == 4){
                DB::table('forge.variables')->where('variables.name', 'peachbitcoin')->update(['valueseur' => 0]);
            }
            if($provider[0] == 5){
                DB::table('forge.variables')->where('variables.name', 'coinbase')->update(['valueseur' => 0]);
            }
            $total_num -= 1;
            //dd("entrou1");
        }

        catch (\Exception $e) {
            Log::info('CAUGHT EXCEPTION on provider '.$provider[0]);
            $provider[4] = 0;
            if($provider[0] == 0){
                DB::table('forge.variables')->where('variables.name', 'coinmarketcap')->update(['valueseur' => 0]);
            }
            if($provider[0] == 1){
                DB::table('forge.variables')->where('variables.name', 'blockchain')->update(['valueseur' => 0]);
            }
            if($provider[0] == 2){
                DB::table('forge.variables')->where('variables.name', 'coindesk')->update(['valueseur' => 0]);
            }
            if($provider[0] == 3){
                DB::table('forge.variables')->where('variables.name', 'bitstamp')->update(['valueseur' => 0]);
            }
            if($provider[0] == 4){
                DB::table('forge.variables')->where('variables.name', 'peachbitcoin')->update(['valueseur' => 0]);
            }
            if($provider[0] == 5){
                DB::table('forge.variables')->where('variables.name', 'coinbase')->update(['valueseur' => 0]);
            }
            $total_num -= 1;
            //dd("entrou1");
        }
    }        
    DB::table('forge.variables')->where('variables.name', 'total_num')->update(['valuesint' => $total_num]);
    if($total_num == 0){
        $average = 0;
        Log::info('Average value is 0! using previous average');
    }
    else{
        $average = number_format($total / $total_num , 2, '.', '');
        DB::table('forge.variables')->where('variables.name', 'average')->update(['valueseur' => $average]);
    }
    Log::info($average. ' average value from ' .$total_num. ' providers -> 0-' 
    .$providers[0][4].' 1-'. $providers[1][4].' 2-'. $providers[2][4].' 3-'. $providers[3][4].' 4-'. $providers[4][4].' 5-'.$providers[5][4]);

    if($average == 0){
        DB::table('forge.chart_day')->where('Minute', $minute)->update(['value' => null, 'date' => $now]);
        DB::table('forge.variables')->where('variables.name', 'average')->update(['valueseur' => $average]);
    }
    else{
        DB::table('forge.chart_day')->where('Minute', $minute)->update(['value' => $average, 'date' => $now]);
        DB::table('forge.variables')->where('variables.name', 'average')->update(['valueseur' => $average]);
        //check if new ATH, if so, update db
        $ath = DB::table('forge.variables')->where('variables.name', 'ATH')->get('valueseur');
        //Log::info($average. ' value @ '. $now . ' and ATH is ' .$ath[0]->valueseur);
        if($average > $ath[0]->valueseur){
            DB::table('forge.variables')->where('variables.name', 'ATH')->update(['valueseur' => $average, 'date' => $now]);
            Log::info('New ATH: ' .$ath[0]->valueseur);
        }
    }

    if($minute % 10 == 0){
        $id = DB::table('forge.current_chart')->value('current_week');
        if($id == 1007){
            $id = 0;
        }
        $id++;
        DB::table('forge.current_chart')->update(['current_week' => $id]);
        if($average == 0){
            DB::table('forge.chart_week')->where('Id', $id)->update(['value' => null, 'date' => $now]);
        }
        else{
            DB::table('forge.chart_week')->where('Id', $id)->update(['value' => $average, 'date' => $now]);
        }
    }

})->everyMinute();

Schedule::call(function () {
    $average = DB::table('forge.variables')->where('variables.name', 'average')->first()->valueseur;
    $id = DB::table('forge.current_chart')->value('current_month');
    if($id == 1439){
        $id = 0;
    }
    $id++;
    DB::table('forge.current_chart')->update(['current_month' => $id]);
    if($average == 0){
        DB::table('forge.chart_month')->where('Id', $id)->update(['value' => null, 'date' => Carbon::now()]);
    }
    else{
        DB::table('forge.chart_month')->where('Id', $id)->update(['value' => $average, 'date' => Carbon::now()]);
    }
    
})->everyThirtyMinutes();

Schedule::call(function () {
    $average = DB::table('forge.variables')->where('variables.name', 'average')->first()->valueseur;
    $id = DB::table('forge.current_chart')->value('current_year');
    if($id == 1459){
        $id = 0;
    }
    $id++;
    DB::table('forge.current_chart')->update(['current_year' => $id]);
    if($average == 0){
        DB::table('forge.chart_year')->where('Id', $id)->update(['value' => null, 'date' => Carbon::now()]);
    }
    else{
        DB::table('forge.chart_year')->where('Id', $id)->update(['value' => $average, 'date' => Carbon::now()]);
    }
    
})->everySixHours($minutes = 0);


Schedule::call(function () {
    //make stats for the day and save to log
    $value = DB::table('forge.variables')->where('variables.name', 'average')->first()->valueseur;
    $dailyAverage = number_format(DB::table('forge.chart_day')->avg('value'), 2, '.', '');
    $dailyAverageYesterday = DB::table('forge.variables')->where('variables.name', 'dailyAverage')->first()->valueseur;
    $diffPercent = number_format((($dailyAverage-$dailyAverageYesterday)/$dailyAverageYesterday)*100, 2, '.', '');
    $arrow = $diffPercent >= 0 ? "⬆️" : "⬇️";
    
    DB::table('forge.variables')->where('variables.name', 'dailyAverage')->update(['valueseur' => $dailyAverage]);
    Log::info('1 bitcoin ending the day at '.$value.'€! Daily average of '.$dailyAverage.'€ ('.$arrow.' '.$diffPercent.'% compared with previous day)');
    
})->dailyAt('23:59');

//Schedule update exchange rate every four hours
Schedule::call(function () {
    $url = "http://api.exchangeratesapi.io/v1/latest?access_key=".env('EXCHANGE_RATE_KEY')."&format=1&symbols=USD";
    $exchange = json_decode(file_get_contents($url));
    //Log::info('New exchange rate: ' .$exchange->rates->USD);
    if($exchange->rates->USD){
      DB::table('forge.variables')->where('variables.name', 'exchangeRate')->update(['valuesBTC' => $exchange->rates->USD]);
      Log::info('New exchange rate: ' .$exchange->rates->USD);
    }
})->everyFourHours();

