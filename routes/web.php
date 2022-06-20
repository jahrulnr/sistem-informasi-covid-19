<?php

use Illuminate\Support\Facades\Route;

// Homepage
Route::get('/', 'App\Http\Controllers\HomeController@homepage');

// API Periode
Route::get('/periode/{id}', 'App\Http\Controllers\HomeController@getPeriodeData');

// Admin
Route::get('/login', function(){ return redirect('/admin'); });
Route::get('/admin', 'App\Http\Controllers\AdminController@admin');
Route::post('/admin/verify', 'App\Http\Controllers\AdminController@verify');
Route::get('/admin/keluar', 'App\Http\Controllers\AdminController@logout');

// Data Kelurahan
Route::get('/admin/kelurahan', 'App\Http\Controllers\AdminController@kelurahan');
Route::post('/admin/kelurahan/simpan_data', 'App\Http\Controllers\AdminController@simpan_data_kelurahan');
Route::post('/admin/kelurahan/ubah_data', 'App\Http\Controllers\AdminController@ubah_data_kelurahan');
Route::get('/admin/kelurahan/hapus_data/{id}', 'App\Http\Controllers\AdminController@hapus_data_kelurahan');

// Data Covid 19
Route::get('/admin/data_covid19/{id_kelurahan}', 'App\Http\Controllers\AdminController@data_covid19');
Route::post('/admin/data_covid19/{id_kelurahan}/simpan_data', 'App\Http\Controllers\AdminController@simpan_data_covid19');
Route::post('/admin/data_covid19/{id_kelurahan}/ubah_data', 'App\Http\Controllers\AdminController@ubah_data_covid19');
Route::get('/admin/data_covid19/{id_kelurahan}/hapus_data/{id}', 'App\Http\Controllers\AdminController@hapus_data_covid19');

// Periode
Route::get('/admin/periode', 'App\Http\Controllers\AdminController@periode');
Route::get('/admin/periode/kosongkan_data/{id}', 'App\Http\Controllers\AdminController@kosongkan_data_periode');

// User
Route::get('/admin/user', 'App\Http\Controllers\AdminController@user');
Route::post('/admin/user/simpan_data', 'App\Http\Controllers\AdminController@simpan_data_user');
Route::post('/admin/user/ubah_data', 'App\Http\Controllers\AdminController@ubah_data_user');
Route::get('/admin/user/hapus_data/{id}', 'App\Http\Controllers\AdminController@hapus_data_user');

Route::get('/welcome', function () {
    return view('welcome');
});

