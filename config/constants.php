<?php

return [
    'trucks' => [
        'makes' => [
            "MAN", "Scania", "Iveco", "Volvo", "Daf", "Renault", "Mercedes-Benz"
        ]
    ],
    'trailers' => [
        'makes' => [
            "Menci", "Krone", "DE Angelis", "Pavelli", "ZORZI"
        ]
    ],

    'currencies' => [
        '0' => 'EUR / €',
        '1' => 'BGN / LEV'
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

        'users' => [
            'admin' => true,
            'title' => 'Users',
            'icon' => 'fa-users-cog',
            'route' => 'users',
            'submenus' => [
                'all' => [
                    'title' => 'All Users',
                    'route' => 'users'
                ],
                'add' => [
                    'title' => 'New User',
                    'route' => 'addUser'
                ]
            ]
        ],

        'company' => [
            'admin' => true,
            'title' => 'Company',
            'icon' => 'fa-building',
            'route' => 'company'
        ],

        'settings' => [
            'admin' => true,
            'title' => 'Settings',
            'icon' => 'fa-cogs',
            'route' => 'settings'
        ]
    ]
];