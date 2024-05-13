<?php

$api->group(['namespace' => 'App\Http\Controllers\Api\V1'], function ($api) {
    $api->get("getAgent","AgentController@getUser");
});
