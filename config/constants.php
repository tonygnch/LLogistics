<?php

return [
    'trucks' => [
        'makes' => [
            "MAN", "Volvo", "Daf", "Scania", "Renault", "Mercedes-Benz"
        ]
    ],
    'trailers' => [
        'makes' => [
            "DE Angelis", "Pavelli", "ZORZI"
        ]
    ],

    'menus' => [
        'trucks' => [
            'title' => 'Trucks',
            'icon' => 'fa-truck',
            'route' => 'trucks',
            'submenus' => [
                'all' => [
                    'title' => 'All Trucks',
                    'route' => 'trucks'
                ],
                'add' => [
                    'title' => 'Add Truck',
                    'route' => 'addTruck'
                ]
            ]
        ],

        'trailers' => [
            'title' => 'Trailers',
            'icon' => 'fa-truck-loading',
            'route' => 'trailers',
            'submenus' => [
                'all' => [
                    'title' => 'All Trailers',
                    'route' => 'trailers'
                ],
                'add' => [
                    'title' => 'Add Trailer',
                    'route' => 'addTrailer'
                ]
            ]
        ],

        'clients' => [
            'title' => 'Clients',
            'icon' => 'fa-user',
            'route' => 'clients',
            'submenus' => [
                'all' => [
                    'title' => 'All Clients',
                    'route' => 'clients'
                ],
                'add' => [
                    'title' => 'Add Client',
                    'route' => 'addClient'
                ]
            ]
        ],

        'invoices' => [
            'title' => 'Invoices',
            'icon' => 'fa-file',
            'route' => 'invoices',
            'submenus' => [
                'all' => [
                    'title' => 'All Invoices',
                    'route' => 'invoices'
                ],
                'add' => [
                    'title' => 'Add Invoice',
                    'route' => 'addInvoice'
                ]
            ]
        ],

        'trips' => [
            'title' => 'Trips',
            'icon' => 'fa-road',
            'route' => 'trips',
            'submenus' => [
                'all' => [
                    'title' => 'All Trips',
                    'route' => 'trips'
                ],
                'add' => [
                    'title' => 'New Trip',
                    'route' => 'addTrip'
                ]
            ]
        ],

        'drivers' => [
            'title' => 'Drivers',
            'icon' => 'fa-male',
            'route' => 'drivers',
            'submenus' => [
                'all' => [
                    'title' => 'All Drivers',
                    'route' => 'drivers'
                ],
                'add' => [
                    'title' => 'New Driver',
                    'route' => 'addDriver'
                ]
            ]
        ],

        'company' => [
            'title' => 'Company',
            'icon' => 'fa-building',
            'route' => 'company'
        ],

        'settings' => [
            'title' => 'Settings',
            'icon' => 'fa-cogs',
            'route' => 'settings'
        ]
    ]
];