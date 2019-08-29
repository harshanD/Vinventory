<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | The default title of your admin panel, this goes into the title tag
    | of your page. You can override it per page with the title section.
    | You can optionally also specify a title prefix and/or postfix.
    |
    */

    'title' => 'V-Inventory',

    'title_prefix' => '',

    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | This logo is displayed at the upper left corner of your admin panel.
    | You can use basic HTML here if you want. The logo has also a mini
    | variant, used for the mini side bar. Make it 3 letters or so
    |
    */

    'logo' => '<b>V-</b>Inventory',

    'logo_mini' => '<b>V</b>I',

    /*
    |--------------------------------------------------------------------------
    | Skin Color
    |--------------------------------------------------------------------------
    |
    | Choose a skin color for your admin panel. The available skin colors:
    | blue, black, purple, yellow, red, and green. Each skin also has a
    | ligth variant: blue-light, purple-light, purple-light, etc.
    |
    */

    'skin' => 'blue',

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Choose a layout for your admin panel. The available layout options:
    | null, 'boxed', 'fixed', 'top-nav'. null is the default, top-nav
    | removes the sidebar and places your menu in the top navbar
    |
    */

    'layout' => null,

    /*
    |--------------------------------------------------------------------------
    | Collapse Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we choose and option to be able to start with a collapsed side
    | bar. To adjust your sidebar layout simply set this  either true
    | this is compatible with layouts except top-nav layout option
    |
    */

    'collapse_sidebar' => false,

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Register here your dashboard, logout, login and register URLs. The
    | logout URL automatically sends a POST request in Laravel 5.3 or higher.
    | You can set the request to a GET or POST with logout_method.
    | Set register_url to null if you don't want a register link.
    |
    */

    'dashboard_url' => 'home',

    'logout_url' => 'logout',

    'logout_method' => null,

    'login_url' => 'login',

    'register_url' => 'register',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Specify your menu items to display in the left sidebar. Each menu item
    | should have a text and and a URL. You can also specify an icon from
    | Font Awesome. A string instead of an array represents a header in sidebar
    | layout. The 'can' is a filter on Laravel's built in Gate functionality.
    |
    */

    'menu' => [
        'MAIN NAVIGATION',
        [
            'text' => 'Blog',
            'url' => 'admin/blog',
            'can' => 'manage-blog',
        ],
        [
            'text' => 'Home',
            'url' => '/home',
            'icon' => 'home',
            'label_color' => 'success',
        ],
        [
            'text' => 'Brands',
            'url' => '/brands',
            'icon' => 'tags',
            'label_color' => 'success',
        ],
        [
            'text' => 'Categories',
            'url' => '/categories',
            'icon' => 'duplicate',
            'label_color' => 'success',
        ],
        [
            'text' => 'Locations',
            'url' => '/locations',
            'icon' => 'map-marker',
            'label_color' => 'success',
        ],
        [
            'text' => 'Supplier',
            'url' => '/supplier',
            'icon' => 'truck',
            'label_color' => 'success',
        ],
        [
            'text' => 'Pages',
            'url' => 'admin/pages',
            'icon' => 'file',
            'label' => 4,
            'label_color' => 'success',
        ],
        'SUB NAVIGATION',
        [
            'text' => 'Products',
            'icon' => 'gift',
            'submenu' => [
                [
                    'text' => 'Add Product',
                    'url' => 'products/create',
                ], [
                    'text' => 'Manage Product',
                    'url' => 'products',
                ],
            ]
        ], [
            'text' => 'User',
            'icon' => 'user',
            'submenu' => [
                [
                    'text' => 'Add Users',
                    'icon' => 'user',
                    'url' => '/user/register',
                ], [
                    'text' => 'Manage users',
                    'icon' => 'user',
                    'url' => '/user/manage',
                ],
            ]
        ], [
            'text' => 'Adjustment',
            'icon' => 'user',
            'submenu' => [
                [
                    'text' => 'Add Adjustment',
                    'icon' => 'user',
                    'url' => '/adjustment/add',
                ], [
                    'text' => 'Manage Adjustment',
                    'icon' => 'user',
                    'url' => '/adjustment/manage',
                ],
            ]
        ], [
            'text' => 'Purchase Order',
            'icon' => 'user',
            'submenu' => [
                [
                    'text' => 'Add PO',
                    'icon' => 'user',
                    'url' => '/po/add',
                ], [
                    'text' => 'PO manage',
                    'icon' => 'user',
                    'url' => '/po/manage',
                ],
            ]
        ], [
            'text' => 'Transfers',
            'icon' => 'user',
            'submenu' => [
                [
                    'text' => 'Add Transfer',
                    'icon' => 'user',
                    'url' => '/transfer/add',
                ], [
                    'text' => 'List Transfer',
                    'icon' => 'user',
                    'url' => '/transfer/manage',
                ],
            ]
        ], [
            'text' => 'Customers',
            'icon' => 'user',
            'submenu' => [
                [
                    'text' => 'Add customer',
                    'icon' => 'user',
                    'url' => '/customer/add',
                ], [
                    'text' => 'List customer',
                    'icon' => 'user',
                    'url' => '/customer/manage',
                ],
            ]
        ], [
            'text' => 'Billers',
            'icon' => 'user',
            'submenu' => [
                [
                    'text' => 'Add Biller',
                    'icon' => 'user',
                    'url' => '/biller/add',
                ], [
                    'text' => 'List Billers',
                    'icon' => 'user',
                    'url' => '/biller/manage',
                ],
            ]
        ], [
            'text' => 'Sales',
            'icon' => 'user',
            'submenu' => [
                [
                    'text' => 'Add Sale',
                    'icon' => 'user',
                    'url' => '/sales/add',
                ], [
                    'text' => 'List Sales',
                    'icon' => 'user',
                    'url' => '/sales/manage',
                ],
            ]
        ], [
            'text' => 'Returns',
            'icon' => 'user',
            'submenu' => [
                [
                    'text' => 'Add Returns',
                    'icon' => 'user',
                    'url' => '/returns/add',
                ], [
                    'text' => 'List Sales',
                    'icon' => 'user',
                    'url' => '/returns/manage',
                ],
            ]
        ],
        'ACCOUNT SETTINGS',
        [
            'text' => 'Profile',
            'url' => 'admin/settings',
            'icon' => 'user',
        ],
        [
            'text' => 'Change Password',
            'url' => 'admin/settings',
            'icon' => 'lock',
        ],
        [
            'text' => 'Settings',
            'icon' => 'share',
            'submenu' => [
                [
                    'text' => 'Tax Rates',
                    'url' => 'tax/',
                ],
                [
                    'text' => 'Level One',
                    'url' => '#',
                ], [
                    'text' => 'Level One',
                    'url' => '#',
                    'submenu' => [
                        [
                            'text' => 'Level Two',
                            'url' => '#',
                        ],
                        [
                            'text' => 'Level Two',
                            'url' => '#',
                            'submenu' => [
                                [
                                    'text' => 'Level Three',
                                    'url' => '#',
                                ],
                                [
                                    'text' => 'Level Three',
                                    'url' => '#',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
        'LABELS',
        [
            'text' => 'Important',
            'icon_color' => 'red',
        ],
        [
            'text' => 'Warning',
            'icon_color' => 'yellow',
        ],
        [
            'text' => 'Information',
            'icon_color' => 'aqua',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Choose what filters you want to include for rendering the menu.
    | You can add your own filters to this array after you've created them.
    | You can comment out the GateFilter if you don't want to use Laravel's
    | built in Gate functionality
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Choose which JavaScript plugins should be included. At this moment,
    | only DataTables is supported as a plugin. Set the value to true
    | to include the JavaScript file from a CDN via a script tag.
    |
    */

    'plugins' => [
        'datatables' => true,
        'select2' => true,
        'chartjs' => true,
    ],
];
