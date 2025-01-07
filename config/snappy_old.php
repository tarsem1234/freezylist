<?php

return [
    'pdf' => [
        'enabled' => true,
        'binary' => '/snappy/wkhtmltopdf',
        'timeout' => false,
        'options' => [],
        'env' => [],
    ],
    'image' => [
        'enabled' => true,
        'binary' => '/snappy/wkhtmltoimage',
        'timeout' => false,
        'options' => [],
        'env' => [],
    ],

];
