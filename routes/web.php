<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('firebase/login');
});
Route::get('yazokulu', function () {
    return view('yazokulu');
});

Route::get('profilepage', function () {
    return view('profilepage');
});

Route::get('login', function () {
    return view('firebase/login');
});
Route::get('yataygecis', function () {
    return view('yataygecis');
});
 
Route::get('profilduzenle', function () {
    return view('profilduzenle');
});
Route::get('profilduzenle', function () {
    return view('profilduzenle');
});
Route::get('adminprofile', function () {
    return view('adminprofile');
});
Route::get('basvurular', function () {
    return view('basvurular');
});

Route::get('listele', function () {
    return view('listele');
});
Route::get('yataygecisbasvurulari', function () {
    return view('yataygecisbasvurulari');
});

Route::get('yazokulubasvurulari', function () {
    return view('yazokulubasvurulari');
});
Route::get('capbasvurulari', function () {
    return view('capbasvurulari');
});

Route::get('dgsbasvurulari', function () {
    return view('dgsbasvurulari');
});
Route::get('dersintibaki', function () {
    return view('dersintibaki');
});

Route::get('dgsbasvuru', function () {
    return view('firebase/basvurular/dgsbasvuru');
});
Route::get('capbasvuru', function () {
    return view('firebase/basvurular/capbasvuru');
});
Route::get('dersintibaki', function () {
    return view('firebase/basvurular/dersintibaki');
});

Route::group([  
    'middleware' => 'firebase',  
  ], function () {  
     return view('profilepage');
     return view('yazokulu');
     return view('profilepage');
     return view('yataygecis');
     return view('profilduzenle');
     return view('adminprofile');
     
});  


Route::get('create','App\Http\Controllers\Firebase\ContactController@create');
Route::get('index','App\Http\Controllers\Firebase\ContactController@index');
//Route::post('signUp','App\Http\Controllers\Firebase\ContactController@_store');
Route::get('signIn','App\Http\Controllers\Firebase\ContactController@signIn');
Route::post('signUp','App\Http\Controllers\Firebase\ContactController@signUp');
Route::post('basvuru','App\Http\Controllers\Firebase\ContactController@basvuru');
Route::get('signOut','App\Http\Controllers\Firebase\ContactController@signOut');
Route::get('read','App\Http\Controllers\Firebase\ContactController@read');

Route::get('yazokulubasvurulari','App\Http\Controllers\Firebase\ContactController@YazBasvuruListele'); 
Route::get('yataygecisbasvurulari','App\Http\Controllers\Firebase\ContactController@YatayBasvuruListele');//yatay başvuru
Route::get('dgsbasvurulari','App\Http\Controllers\Firebase\ContactController@DgsListele');
Route::get('dersintibaki','App\Http\Controllers\Firebase\ContactController@İntibakListele');
Route::get('capbasvurulari','App\Http\Controllers\Firebase\ContactController@CapListele');

Route::put('update','App\Http\Controllers\Firebase\ContactController@update');
Route::put('basvuruOnayla','App\Http\Controllers\Firebase\ContactController@basvuruOnayla');
Route::get('edit','App\Http\Controllers\Firebase\ContactController@edit');