<?php

use Illuminate\Support\Facades\Route;

Route::get('/{any}', function () {
    return view('App'); // Your Vue app
})->where('any', '.*');


