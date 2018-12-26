<?php

return [
    [
        'menu' => [
            [
                'crud' => 'stores',
                'icon' => 'fa fa-store',
            ],
            [
                'crud' => 'orders',
                'icon' => 'fa fa-clipboard-list',
            ],
        ],
    ],
    [
        'name' => 'storekeeper',
        'menu' => [
            [
                'crud' => 'storekeeper.stores',
                'icon' => 'fa fa-store',
            ],
            [
                'crud' => 'storekeeper.providers',
                'icon' => 'fa fa-box-open',
            ],
            [
                'crud' => 'storekeeper.orders',
                'icon' => 'fa fa-clipboard-list',
            ],
        ],
    ],
    [
        'name' => 'provider',
        'menu' => [
            [
                'crud' => 'provider.orders',
                'icon' => 'fa fa-clipboard-list',
            ],
            [
                'crud' => 'provider.products',
                'icon' => 'fa fa-shopping-basket',
            ],
        ],
    ],
];
