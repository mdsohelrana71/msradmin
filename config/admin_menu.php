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
        'title' => 'Product Brands',
        'route' => 'admin.brands.index',
        'icon' => 'fa fa-tags',
        'permission' => 'brands.view',
    ],
    [
        'title' => 'Product Attributes',
        'route' => 'admin.product-attributes.index',
        'icon' => 'fa fa-sliders-h',
        'permission' => 'product-attributes.view',
    ],
    [
        'title' => 'Product Inventory',
        'route' => 'admin.product-inventory.index',
        'icon' => 'fa fa-boxes',
        'permission' => 'product-inventory.view',
    ],
    [
        'title' => 'Product Wishlists',
        'route' => 'admin.product-wishlists.index',
        'icon' => 'fa fa-heart',
        'permission' => 'product-wishlists.view',
    ],
    [
        'title' => 'Product FAQs',
        'route' => 'admin.product-faqs.index',
        'icon' => 'fas fa-question-circle',
        'permission' => 'product-faqs.view',
    ],
    [
        'title' => 'Product Reviews',
        'route' => 'admin.product-reviews.index',
        'icon' => 'fa fa-star',
        'permission' => 'product-reviews.view',
    ],
    [
        'title' => 'Product Compares',
        'route' => 'admin.product-compares.index',
        'icon' => 'fa fa-exchange-alt',
        'permission' => 'product-compares.view',
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
        'title' => 'Settings',
        'route' => 'admin.settings.index',
        'icon' => 'fa fa-cog',
        'permission' => 'settings.view',
    ],
    [
        'title' => 'Store Settings',
        'route' => 'admin.store-settings.index',
        'icon' => 'fa fa-cog',
        'permission' => 'store-settings.view',
    ],
];