<?php

Route::get('/teams', 'Api\TeamController@getTeamsAction');
Route::delete('/teams', 'Api\TeamController@deleteTeamsAction');
Route::post('/teams', 'Api\TeamController@postTeamsAction');
Route::get('/matches/{week}', 'Api\MatchController@getWeeklyMatchesAction');
Route::post('/matches/{week}', 'Api\MatchController@postPlayWeeklyMatchAction');
Route::post('/fixture', 'Api\FixtureController@postGenerateFixtureAction');
Route::delete('/fixture', 'Api\FixtureController@deleteFixtureAction');
