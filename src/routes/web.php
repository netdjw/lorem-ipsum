<?php

Route::group(['namespace' => 'netdjw\LoremIpsum\Http\Controllers', 'middleware' => ['web']], function() {
    Route::get('lipsum/{lang}/{limit}', 'LoremIpsumController@html');
});
