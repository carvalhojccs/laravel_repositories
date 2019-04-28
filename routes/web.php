<?php

$this->any('admin/products/search','Admin\ProductController@search')->name('products.search');
$this->resource('admin/products','Admin\ProductController');

Route::any('admin/categories/search','Admin\CategoryController@search')->name('categories.search');
Route::resource('admin/categories','Admin\CategoryController');

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

$this->get('/', 'DashboardController@index')->name('admin');
