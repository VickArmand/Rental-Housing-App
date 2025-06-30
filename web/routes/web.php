<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('entry');
});
// Route::fallback(function () {
    // return view('entry');
// });

Route::get('{any}', function () {
    return view('entry');
})->where('any', '^(?!route$).*');