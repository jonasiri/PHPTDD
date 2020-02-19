<?php

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

Route::get('/books', function () {
    return view('welcome');
})->name('get-books');


Route::get('/books/{book}', 'BooksController@getBook')->name('get-book');
Route::post('/books', 'BooksController@store')->name('add-book');
Route::patch('/books/{book}', 'BooksController@update')->name('update-book');
Route::delete('/books/{book}', 'BooksController@destroy')->name('delete-book');

Route::post('/authors', 'AuthorsController@store')->name('add-author');


Route::post('/checkout/{book}', 'CheckoutBookController@store')->name('checkout-book');
Route::post('/checkin/{book}', 'CheckinBookController@store')->name('check-in-book');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
