<?php

return [
    'products' => [
        'label' => 'Products',
        'permissions' => [
            'products.view' => 'View products',
            'products.create' => 'Create products',
            'products.edit' => 'Edit products',
            'products.delete' => 'Delete products',
            'products.approve' => 'Approve products',
        ],
    ],

    'product_categories' => [
        'label' => 'Product Categories',
        'permissions' => [
            'product_categories.view' => 'View product categories',
            'product_categories.create' => 'Create products categories',
            'product_categories.edit' => 'Edit product categories',
            'product_categories.delete' => 'Delete product categories',
        ],
    ],

    'blogs' => [
        'label' => 'Blogs',
        'permissions' => [
            'blogs.view' => 'View blogs',
            'blogs.create' => 'Create blogs',
            'blogs.edit' => 'Edit blogs',
            'blogs.delete' => 'Delete blogs',
            'blogs.approve' => 'Approve blogs',
        ],
    ],

    'blog_categories' => [
        'label' => 'Blog Categories',
        'permissions' => [
            'blog_categories.view' => 'View blog categories',
            'blog_categories.create' => 'Create blog categories',
            'blog_categories.edit' => 'Edit blog categories',
            'blog_categories.delete' => 'Delete blog categories',
        ],
    ],

    'users' => [
        'label' => 'Users',
        'permissions' => [
            'users.view' => 'View users',
            'users.create' => 'Create users',
            'users.edit' => 'Edit users',
            'users.delete' => 'Delete users',
        ],
    ],

    'roles' => [
        'label' => 'Roles',
        'permissions' => [
            'roles.view' => 'View roles',
            'roles.create' => 'Create roles',
            'roles.edit' => 'Edit roles',
            'roles.delete' => 'Delete roles',
        ],
    ],

    'settings' => [
        'label' => 'Settings',
        'permissions' => [
            'settings.view' => 'View settings',
            'settings.edit' => 'Edit settings',
        ],
    ],
];