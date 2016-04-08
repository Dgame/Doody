<?php

Route::group(['prefix' => 'crawler', 'namespace' => 'Modules\Crawler\Http\Controllers'], function()
{
	Route::get('/', 'CrawlerController@index');
});