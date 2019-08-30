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
        'SUB NAVIGATION',
        [
            'text' => 'Products',
            'icon' => 'barcode',
            'submenu' => [
                [
                    'text' => 'Manage Product',
                    'icon' => 'barcode',
                    'url' => 'products',
                ], [
                    'text' => 'Add Product',
                    'icon' => 'plus-circle',
                    'url' => 'products/create',
                ], [
                    'text' => 'Manage Adjustment',
                    'icon' => 'filter',
                    'url' => '/adjustment/manage',
                ], [
                    'text' => 'Quantity Adjustment',
                    'icon' => 'filter',
                    'url' => '/adjustment/add',
                ],
            ]
        ], [
            'text' => 'Sales',
            'icon' => 'heart',
            'submenu' => [
                [
                    'text' => 'List Sales',
                    'icon' => 'heart',
                    'url' => '/sales/manage',
                ], [
                    'text' => 'Add Sale',
                    'icon' => 'plus-circle',
                    'url' => '/sales/add',
                ],
            ]
        ], [
            'text' => 'Purchase Order',
            'icon' => 'star',
            'submenu' => [
                [
                    'text' => 'List PO',
                    'icon' => 'star',
                    'url' => '/po/manage',
                ], [
                    'text' => 'Add PO',
                    'icon' => 'plus-circle',
                    'url' => '/po/add',
                ],
            ]
        ], [
            'text' => 'Transfers',
            'icon' => 'star-o',
            'submenu' => [
                [
                    'text' => 'List Transfer',
                    'icon' => 'star-o',
                    'url' => '/transfer/manage',
                ], [
                    'text' => 'Add Transfer',
                    'icon' => 'plus-circle',
                    'url' => '/transfer/add',
                ],
            ]
        ], [
            'text' => 'Returns',
            'icon' => 'random',
            'submenu' => [
                [
                    'text' => 'List Sales',
                    'icon' => 'random',
                    'url' => '/returns/manage',
                ], [
                    'text' => 'Add Returns',
                    'icon' => 'plus-circle',
                    'url' => '/returns/add',
                ],
            ]
        ], [
            'text' => 'People',
            'icon' => 'users',
            'submenu' => [
                [
                    'text' => 'List users',
                    'icon' => 'users',
                    'url' => '/user/manage',
                ], [
                    'text' => 'Add Users',
                    'icon' => 'user-plus',
                    'url' => '/user/register',
                ], [
                    'text' => 'List Billers',
                    'icon' => 'users',
                    'url' => '/biller/manage',
                ], [
                    'text' => 'Add Biller',
                    'icon' => 'plus-circle',
                    'url' => '/biller/add',
                ], [
                    'text' => 'List customer',
                    'icon' => 'users',
                    'url' => '/customer/manage',
                ], [
                    'text' => 'Add customer',
                    'icon' => 'plus-circle',
                    'url' => '/customer/add',
                ], [
                    'text' => 'List and Add Suppliers',
                    'icon' => 'users',
                    'url' => '/supplier',
                ],
            ]
        ], [
            'text' => 'Settings',
            'icon' => 'gear',
            'submenu' => [
                [
                    'text' => 'Tax Rates',
                    'icon' => 'plus-circle',
                    'url' => '/tax',
                ], [
                    'text' => 'Brands',
                    'icon' => 'th-list',
                    'url' => '/brands',
                ], [
                    'text' => 'Categories',
                    'icon' => 'folder-open',
                    'url' => '/categories',
                ], [
                    'text' => 'Warehouses',
                    'icon' => 'building-o',
                    'url' => '/locations',
                ],
//                [
//                    'text' => 'Level One',
//                    'url' => '#',
//                    'submenu' => [
//                        [
//                            'text' => 'Level Two',
//                            'url' => '#',
//                        ],
//                        [
//                            'text' => 'Level Two',
//                            'url' => '#',
//                            'submenu' => [
//                                [
//                                    'text' => 'Level Three',
//                                    'url' => '#',
//                                ],
//                                [
//                                    'text' => 'Level Three',
//                                    'url' => '#',
//                                ],
//                            ],
//                        ],
//                    ],
//                ],

            ],
        ],
        'ACCOUNT SETTINGS',
        [
            'text' => 'Profile',
            'url' => 'user/manage/',
            'icon' => 'user',
        ],
        [
            'text' => 'Change Password',
            'url' => 'admin/settings',
            'icon' => 'lock',
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
