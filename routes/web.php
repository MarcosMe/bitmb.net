<?php

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {

    //dd($averageFromProviders);
    return view('test');
});

Route::get('/', function () {

    //dd($averageFromProviders);
    return view('welcome');
});
