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


//ALL BOOKS ROUTES
Route::get('/books','BooksController@index');
Route::post('/books','BooksController@create');
Route::post('/books_title','BooksController@findBooksByTitle');
Route::post('/books_isbn','BooksController@findBooksByIsbn');
Route::post('/search_books','BooksController@generalSearch');

Route::group(['prefix' => 'report'], function() {
    Route::get('/titles', 'BooksController@reportTitles');
    Route::get('/year', 'BooksController@reportYear');
    Route::get('/genres', 'BooksController@reportGenres');
});


