<?php

Route::group(['namespace' => 'Dashboard'], function () {
    Route::get('/', 'DashboardController@index')
        ->name('dashboard');

    Route::get('/button/edit/{id}', 'DashboardController@editForm')
        ->where(['id' => '[0-9]+'])
        ->name('button_edit');

    Route::post('/button/edit/{id}', 'DashboardController@edit')
        ->where(['id' => '[0-9]+'])
        ->name('button_edit');
});
