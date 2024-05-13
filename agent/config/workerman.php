<?php

return [

    'option' => [
        'service' => \App\Workerman\Option\Option::class,
        'eventHandler' => \App\Workerman\Option\Events::class,
    ],

    'exchange' => [
        'service' => \App\Workerman\Exchange\Exchange::class,
        'eventHandler' => \App\Workerman\Exchange\Events::class,
    ],

];
