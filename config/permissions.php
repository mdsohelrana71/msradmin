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
];
