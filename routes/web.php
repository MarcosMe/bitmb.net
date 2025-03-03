<?php

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {

    //dd($averageFromProviders);
    return view('test');
});

Route::get('/', function () {

    //dd($averageFromProviders);
    return view('welcome');
});

Route::get('/api', function (Request $request) {
    //dd($request);
    
    if($request->string){
        $average = DB::table('forge.variables')->where('Name', 'average')->first()->ValuesEUR;
        if($request->average){
            return Response::json($average);
        }
        if($request->ath){
            $ath = DB::table('forge.variables')->where('Name', 'ATH')->get('ValuesEUR');
            $athDate = DB::table('forge.variables')->where('Name', 'ATH')->get('date');
            $athPercentage = number_format(100 - (($average * 100) / (float)$ath[0]->ValuesEUR), 2, '.', '');
            $responseCollection = collect(['BTC_in_Euro' => $average, 
                                            'ath_percentage' => $athPercentage,
                                            'all_time_high_in_EUR' => $ath[0]->ValuesEUR,
                                            'ath_date' => Carbon::parse($athDate[0]->Date)]);
            return Response::json($responseCollection);
        }
        $coinmarketcap = DB::table('forge.variables')->where('Name', 'coinmarketcap')->first()->ValuesEUR;
        $blockchain = DB::table('forge.variables')->where('Name', 'blockchain')->first()->ValuesEUR;
        $coindesk = DB::table('forge.variables')->where('Name', 'coindesk')->first()->ValuesEUR;
        $bitstamp = DB::table('forge.variables')->where('Name', 'bitstamp')->first()->ValuesEUR;
        $peachbitcoin = DB::table('forge.variables')->where('Name', 'peachbitcoin')->first()->ValuesEUR;
        $coinbase = DB::table('forge.variables')->where('Name', 'coinbase')->first()->ValuesEUR;
        $providers = ['coinmarketcap' => $coinmarketcap, 
                        'blockchain' => $blockchain, 
                        'coindesk' => $coindesk, 
                        'bitstamp' => $bitstamp,
                        'peachbitcoin' => $peachbitcoin,
                        'coinbase' =>  $coinbase];
        
        $dailyAverageYesterday = DB::table('forge.variables')->where('Name', 'dailyAverage')->first()->ValuesEUR;
        $total_num = DB::table('forge.variables')->where('Name', 'total_num')->first()->ValuesINT;

        $ath = DB::table('forge.variables')->where('Name', 'ATH')->get('ValuesEUR');
        $athDate = DB::table('forge.variables')->where('Name', 'ATH')->get('Date');
        $athPercentage = number_format(100 - (($average * 100) / (float)$ath[0]->ValuesEUR), 2, '.', '');


        $responseCollection = collect(['BTC_in_Euro' => $average, 
                                        'ath_percentage' => $athPercentage,
                                        'number_of_providers' => $total_num, 
                                        'list_of_providers' => $providers, 
                                        'yesterday_daily_average' => $dailyAverageYesterday,
                                        'all_time_high_in_EUR' => $ath[0]->ValuesEUR,
                                        'ath_date' => Carbon::parse($athDate[0]->Date)]);
        return Response::json($responseCollection);
    }
    else{
        $average = (float)DB::table('forge.variables')->where('Name', 'average')->first()->ValuesEUR;
        if($request->average){
            return Response::json($average);
        }

        if($request->ath){
            $ath = DB::table('forge.variables')->where('Name', 'ATH')->get('ValuesEUR');
            $athDate = DB::table('forge.variables')->where('Name', 'ATH')->get('Date');
            $athPercentage = number_format(100 - (($average * 100) / (float)$ath[0]->ValuesEUR), 2, '.', '');
            $responseCollection = collect(['BTC_in_Euro' => $average, 
                                        'ath_percentage' => (float)$athPercentage,
                                        'all_time_high_in_EUR' => (float)$ath[0]->ValuesEUR,
                                        'ath_date' => Carbon::parse($athDate[0]->Date)]);
            return Response::json($responseCollection);
        }

        $coinmarketcap = (float)DB::table('forge.variables')->where('Name', 'coinmarketcap')->first()->ValuesEUR;
        $blockchain = (float)DB::table('forge.variables')->where('Name', 'blockchain')->first()->ValuesEUR;
        $coindesk = (float)DB::table('forge.variables')->where('Name', 'coindesk')->first()->ValuesEUR;
        $bitstamp = (float)DB::table('forge.variables')->where('Name', 'bitstamp')->first()->ValuesEUR;
        $peachbitcoin = (float)DB::table('forge.variables')->where('Name', 'peachbitcoin')->first()->ValuesEUR;
        $coinbase = (float)DB::table('forge.variables')->where('Name', 'coinbase')->first()->ValuesEUR;
        $providers = ['coinmarketcap' => $coinmarketcap, 
                        'blockchain' => $blockchain, 
                        'coindesk' => $coindesk, 
                        'bitstamp' => $bitstamp,
                        'peachbitcoin' => $peachbitcoin,
                        'coinbase' =>  $coinbase];
        
        $dailyAverageYesterday = (float)DB::table('forge.variables')->where('Name', 'dailyAverage')->first()->ValuesEUR;
        $total_num = DB::table('forge.variables')->where('Name', 'total_num')->first()->ValuesINT;

        $ath = DB::table('forge.variables')->where('Name', 'ATH')->get('ValuesEUR');
        $athDate = DB::table('forge.variables')->where('Name', 'ATH')->get('Date');
        $athPercentage = number_format(100 - (($average * 100) / (float)$ath[0]->ValuesEUR), 2, '.', '');
        
        $responseCollection = collect(['BTC_in_Euro' => $average, 
                                        'ath_percentage' => (float)$athPercentage,
                                        'number_of_providers' => $total_num, 
                                        'list_of_providers' => $providers, 
                                        'yesterday_daily_average' => $dailyAverageYesterday,
                                        'all_time_high_in_EUR' => (float)$ath[0]->ValuesEUR,
                                        'ath_date' => Carbon::parse($athDate[0]->Date)]);
        return Response::json($responseCollection);
    }
})->middleware('throttle:10,1');

