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
        'icon' => 'fa fa-user-cog',
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
        'title' => 'Product Categories',
        'route' => 'admin.product-categories.index',
        'icon' => 'fa fa-folder',
        'permission' => 'product_categories.view',
    ],
    [
        'title' => 'Products',
        'route' => 'admin.products.index',
        'icon' => 'fa fa-box',
        'permission' => 'products.view',
    ],
    [
        'title' => 'Brands',
        'route' => 'admin.brands.index',
        'icon' => 'fa fa-tags',
        'permission' => 'brands.view',
    ],
    [
        'title' => 'Blog Categories',
        'route' => 'admin.blog-categories.index',
        'icon' => 'fa fa-folder',
        'permission' => 'blog_categories.view',
    ],
    [
        'title' => 'Blogs',
        'route' => 'admin.blogs.index',
        'icon' => 'fa fa-newspaper',
        'permission' => 'blogs.view',
    ],
    [
        'title' => 'Site settings',
        'route' => 'admin.settings.index',
        'icon' => 'fa fa-cog',
        'permission' => 'settings.view',
    ],
];