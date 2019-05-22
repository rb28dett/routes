<?php

Route::group([
        'middleware' => [
            'web', 'rb28dett.base', 'rb28dett.auth',
            'can:access,RB28DETT\Routes\Models\Route',
        ],
        'prefix'    => config('rb28dett.settings.base_url'),
        'namespace' => 'RB28DETT\Routes\Controllers',
        'as'        => 'rb28dett::routes.',
    ], function () {
        Route::get('routes', 'RoutesController@routes')->name('index');
    });
