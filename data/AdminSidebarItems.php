<?php
return [
    [
        'route' => 'admin.dashboard',
        'icon' => 'fas fa-fw fa-tachometer-alt',
        'label' => 'Dashboard'
    ],

    [
        'icon' => 'fas fa-fw fa-table',
        'label' => 'Categories',
        'submenu' => [
            ['url' => 'admin.categories.index', 'label' => 'index'],
            ['url' => 'admin.categories.create', 'label' => 'Create'],
        ]
    ],
//    [
//        'icon' => 'fas fa-fw fa-wrench',
//        'label' => 'Products',
//        'submenu' => [
//            ['url' => 'admin.products.index', 'label' => 'index'],
//            ['url' => 'admin.products.create', 'label' => 'Create'],
//        ]
//    ],

];
