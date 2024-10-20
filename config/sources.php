<?php

return [
    'NewsAPI' => [
        'api_key' => env('NEWSAPI_API_KEY'),
    ],
    'TheGuardian' => [
        'api_key' => env('THE_GUARDIAN_API_KEY'),
    ],
    'NewYorkTimes' => [
        'api_key' => env('NEW_YORK_TIMES_KEY'),
        'api_secret' => env('NEW_YORK_TIMES_SECRET'),
    ]
];
