<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'petugascontroller@register');
Route::post('login', 'petugascontroller@login');
Route::get('user', 'petugascontroller@show');
Route::put('/petugas/{id}', 'petugascontroller@update')->middleware('jwt.verify');
Route::delete('/petugas/{id}', 'petugascontroller@destroy')->middleware('jwt.verify');

Route::post('/jenis_cuci', 'jeniscontroller@store')->middleware('jwt.verify');
Route::put('/jenis_cuci/{id}', 'jeniscontroller@update')->middleware('jwt.verify');
Route::delete('/jenis_cuci/{id}', 'jeniscontroller@destroy')->middleware('jwt.verify');
Route::get('/jenis_cuci', 'jeniscontroller@show')->middleware('jwt.verify');

Route::post('/pelanggan', 'pelanggancontroller@store')->middleware('jwt.verify');
Route::put('/pelanggan/{id}', 'pelanggancontroller@update')->middleware('jwt.verify');
Route::delete('/pelanggan/{id}', 'pelanggancontroller@destroy')->middleware('jwt.verify');
Route::get('/pelanggan', 'pelanggancontroller@show')->middleware('jwt.verify');

Route::post('/transaksi', 'transaksicontroller@store')->middleware('jwt.verify');
Route::post('/nota', 'transaksicontroller@show')->middleware('jwt.verify');

Route::post('/detail', 'detailcontroller@store')->middleware('jwt.verify');