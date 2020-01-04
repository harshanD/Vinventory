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
            'text' => 'Dashboard',
            'url' => '/home',
            'icon' => 'home',
            'label_color' => 'success',
        ],
        'SUB NAVIGATION',
        [
            'text' => 'Products',
            'icon' => 'barcode',
            'can' => 'viewProduct',
            'submenu' => [
                [
                    'text' => 'Manage Product',
                    'icon' => 'barcode',
                    'url' => 'products',
                    'can' => 'viewProduct',
                ], [
                    'text' => 'Add Product',
                    'icon' => 'plus-circle',
                    'url' => 'products/create',
                    'can' => 'createProduct',
                ], [
                    'text' => 'Manage Adjustment',
                    'icon' => 'filter',
                    'url' => '/adjustment/manage',
                    'can' => 'viewAdjustment',
                ], [
                    'text' => 'Quantity Adjustment',
                    'icon' => 'filter',
                    'url' => '/adjustment/add',
                    'can' => 'createAdjustment',
                ],
            ]
        ], [
            'text' => 'Sales',
            'icon' => 'heart',
            'can' => 'viewSale',
            'submenu' => [
                [
                    'text' => 'List Sales',
                    'icon' => 'heart',
                    'url' => '/sales/manage',
                    'can' => 'viewSale',
                ], [
                    'text' => 'Add Sale',
                    'icon' => 'plus-circle',
                    'url' => '/sales/add',
                    'can' => 'createSale',
                ],
            ]
        ], [
            'text' => 'Purchase Order',
            'icon' => 'star',
            'can' => 'viewOrder',
            'submenu' => [
                [
                    'text' => 'List PO',
                    'icon' => 'star',
                    'url' => '/po/manage',
                    'can' => 'viewOrder',
                ], [
                    'text' => 'Add PO',
                    'icon' => 'plus-circle',
                    'url' => '/po/add',
                    'can' => 'createOrder',
                ],
            ]
        ], [
            'text' => 'Transfers',
            'icon' => 'star-o',
            'can' => 'viewTransfer',
            'submenu' => [
                [
                    'text' => 'List Transfer',
                    'icon' => 'star-o',
                    'url' => '/transfer/manage',
                    'can' => 'viewTransfer',
                ], [
                    'text' => 'Add Transfer',
                    'icon' => 'plus-circle',
                    'url' => '/transfer/add',
                    'can' => 'createTransfer',
                ],
            ]
        ], [
            'text' => 'Returns',
            'icon' => 'random',
            'can' => 'viewReturns',
            'submenu' => [
                [
                    'text' => 'List Returns',
                    'icon' => 'random',
                    'url' => '/returns/manage',
                    'can' => 'viewReturns',
                ], [
                    'text' => 'Add Returns',
                    'icon' => 'plus-circle',
                    'url' => '/returns/add',
                    'can' => 'createReturns',
                ],
            ]
        ], [
            'text' => 'People',
            'icon' => 'users',
            'can' => 'viewPeople',
            'submenu' => [
                [
                    'text' => 'List users',
                    'icon' => 'users',
                    'url' => '/user/manage',
                    'can' => 'viewUser',
                ], [
                    'text' => 'Add Users',
                    'icon' => 'user-plus',
                    'url' => '/user/register',
                    'can' => 'createUser',
                ], [
                    'text' => 'List Billers',
                    'icon' => 'users',
                    'url' => '/biller/manage',
                    'can' => 'viewBiller',
                ], [
                    'text' => 'Add Biller',
                    'icon' => 'plus-circle',
                    'url' => '/biller/add',
                    'can' => 'createBiller',
                ], [
                    'text' => 'List customer',
                    'icon' => 'users',
                    'url' => '/customer/manage',
                    'can' => 'viewCustomer',
                ], [
                    'text' => 'Add customer',
                    'icon' => 'plus-circle',
                    'url' => '/customer/add',
                    'can' => 'createCustomer',
                ], [
                    'text' => 'List and Add Suppliers',
                    'icon' => 'users',
                    'url' => '/supplier',
                    'can' => 'viewSupplier',
                ],
            ]
        ], [
            'text' => 'Settings',
            'icon' => 'gear',
            'can' => 'viewSettings',
            'submenu' => [
                [
                    'text' => 'Tax Rates',
                    'icon' => 'plus-circle',
                    'url' => '/tax',
                    'can' => 'viewTax',
                ], [
                    'text' => 'Brands',
                    'icon' => 'th-list',
                    'url' => '/brands',
                    'can' => 'viewBrand',
                ], [
                    'text' => 'Categories',
                    'icon' => 'folder-open',
                    'url' => '/categories',
                    'can' => 'viewCategory',
                ], [
                    'text' => 'Warehouses',
                    'icon' => 'building-o',
                    'url' => '/locations',
                    'can' => 'viewWarehouse',
                ], [
                    'text' => 'Roles',
                    'icon' => 'files-o',
                    'url' => '/role',
                    'can' => 'viewRole',
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
        ], [
            'text' => 'Reports',
            'icon' => 'gear',
            'can' => 'viewReports',
            'submenu' => [
                [
                    'text' => 'Daily Sales',
                    'icon' => 'plus-circle',
                    'url' => 'reports/daily_sales',
                    'can' => 'dailySales',
                ], [
                    'text' => 'Monthly Sales',
                    'icon' => 'plus-circle',
                    'url' => 'reports/monthly_sales',
                    'can' => 'monthlySales',
                ], [
                    'text' => 'Sales Report',
                    'icon' => 'plus-circle',
                    'url' => 'reports/sales',
                    'can' => 'salesReport',
                ], [
                    'text' => 'Payments Report',
                    'icon' => 'plus-circle',
                    'url' => 'reports/payment',
                    'can' => 'paymentsReport',
                ], [
                    'text' => 'Daily Purchases',
                    'icon' => 'plus-circle',
                    'url' => 'reports/daily_purchases',
                    'can' => 'dailyPurchases',
                ], [
                    'text' => 'Monthly Purchases',
                    'icon' => 'plus-circle',
                    'url' => 'reports/monthly_purchases',
                    'can' => 'monthlyPurchases',
                ], [
                    'text' => 'Purchases Report',
                    'icon' => 'plus-circle',
                    'url' => 'reports/purchases',
                    'can' => 'purchasesReport',
                ], [
                    'text' => 'Customers Report',
                    'icon' => 'plus-circle',
                    'url' => 'reports/customers',
                    'can' => 'customersReport',
                ], [
                    'text' => 'Suppliers Report',
                    'icon' => 'plus-circle',
                    'url' => 'reports/suppliers',
                    'can' => 'suppliersReport',
                ], [
                    'text' => 'Product Quantity Alerts',
                    'icon' => 'plus-circle',
                    'url' => '/reports/quantity_alerts',
                    'can' => 'productQualityAlerts',
                ], [
                    'text' => 'Products Report',
                    'icon' => 'plus-circle',
                    'url' => '/reports/products',
                    'can' => 'productsReport',
                ], [
                    'text' => 'Adjustments Report',
                    'icon' => 'plus-circle',
                    'url' => '/reports/adjustment',
                    'can' => 'adjustmentsReport',
                ], [
                    'text' => 'Category Report',
                    'icon' => 'plus-circle',
                    'url' => 'reports/category',
                    'can' => 'categoryReport',
                ], [
                    'text' => 'Brands Report',
                    'icon' => 'plus-circle',
                    'url' => 'reports/brand',
                    'can' => 'brandsReport',
                ],[
                    'text' => 'Warehouse Stock Chart',
                    'icon' => 'plus-circle',
                    'url' => '/reports/warehouse_stock',
                    'can' => 'warehouseStockReport',
                ],
            ],
        ],
        'ACCOUNT SETTINGS',
        [
            'text' => 'Profile',
            'url' => '/user/profile',
            'icon' => 'user',
            'can' => 'viewProfile',
        ],
//        [
//            'text' => 'Change Password',
//            'url' => 'admin/settings',
//            'icon' => 'lock',
//        ],

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
//        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        App\MenuFilter::class,
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
