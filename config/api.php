<?php

return [
    'rate_limit' => env('API_RATE_LIMIT', '120,1'),
    'cors' => [
        'allowed_origins' => explode(',', env('API_ALLOWED_ORIGINS', 'http://localhost:5173')), 
    ],
    'timezone' => 'Asia/Jakarta',
    'currency' => 'IDR',
];
