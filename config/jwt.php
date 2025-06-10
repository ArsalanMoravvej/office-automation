<?php

return [
    'secret' => env('JWT_SECRET', 'your-secret-key'),
    'algo' => 'HS256',
    'ttl' => 600, // seconds
];
