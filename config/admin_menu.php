<?php

return [
    [
        'title' => 'Dashboard',
        'route' => 'admin.dashboard',
        'icon' => 'fa fa-home',
        'permission' => null,
    ],
    [
        'title' => 'Profile',
        'route' => 'admin.accounts.index',
        'icon' => 'fa fa-user',
        'permission' => null,
    ],
    [
        'title' => 'Account settings',
        'route' => 'admin.accounts.index',
        'icon' => 'fa fa-user',
        'permission' => null,
    ],
    [
        'title' => 'Users',
        'route' => 'admin.users.index',
        'icon' => 'fa fa-users',
        'permission' => 'users.view',
    ],
    [
        'title' => 'Roles & Permission',
        'route' => 'admin.roles.index',
        'icon' => 'fa fa-user-shield',
        'permission' => 'roles.view',
    ],
    [
        'title' => 'Accounts',
        'route' => 'admin.accounts.index',
        'icon' => 'fa fa-wallet',
        'permission' => 'accounts.view',
    ],
    [
        'title' => 'Site settings',
        'route' => 'admin.settings.index',
        'icon' => 'fa fa-cog',
        'permission' => 'settings.view',
    ],

];