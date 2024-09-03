<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
    
});
Route::get('/deni', function () {
    echo "aku seorang kapiten";
    
});
Route::get('/aselole', function () {
    echo "nanti malem ajalah biar asik, btw nilai ku gedein ya teh";
    
});