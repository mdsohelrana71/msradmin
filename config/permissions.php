<?php

return [
    'products' => [
        'label' => 'Products',
        'permissions' => [
            'products.view' => 'View products',
            'products.create' => 'Create products',
            'products.edit' => 'Edit products',
            'products.delete' => 'Delete products',
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

    'brands' => [
        'label' => 'Product Brands',
        'permissions' => [
            'brands.view' => 'View brands',
            'brands.create' => 'Create brands',
            'brands.edit' => 'Edit brands',
            'brands.delete' => 'Delete brands',
        ],
    ],

    'product-attributes' => [
        'label' => 'Product Attributes',
        'permissions' => [
            'product-attributes.view' => 'View product attributes',
            'product-attributes.create' => 'Create product attributes',
            'product-attributes.edit' => 'Edit product attributes',
            'product-attributes.delete' => 'Delete product attributes',
        ],
    ],

    'product-inventory' => [
        'label' => 'Product Inventory',
        'permissions' => [
            'product-inventory.view' => 'View product inventory',
            'product-inventory.edit' => 'Edit product inventory',
        ],
    ],

    'product-faqs' => [
        'label' => 'Product FAQs',
        'permissions' => [
            'product-faqs.view' => 'View product FAQs',
            'product-faqs.create' => 'Create product FAQs',
            'product-faqs.edit' => 'Edit product FAQs',
            'product-faqs.delete' => 'Delete product FAQs',
        ],
    ],

    'product-reviews' => [
        'label' => 'Product Reviews',
        'permissions' => [
            'product-reviews.view' => 'View product reviews',
            'product-reviews.edit' => 'Edit product reviews',
            'product-reviews.delete' => 'Delete product reviews',
        ],
    ],

    'product-wishlists' => [
        'label' => 'Product Wishlists',
        'permissions' => [
            'product-wishlists.view' => 'View product wishlists',
            'product-wishlists.delete' => 'Delete product wishlists',
        ],
    ],

    'product-compares' => [
        'label' => 'Product Compares',
        'permissions' => [
            'product-compares.view' => 'View product compares',
            'product-compares.delete' => 'Delete product compares',
        ],
    ],

    'orders' => [
        'label' => 'Orders',
        'permissions' => [
            'orders.view' => 'View orders',
            'orders.edit' => 'Edit orders',
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
            'blog-categories.view' => 'View blog categories',
            'blog-categories.create' => 'Create blog categories',
            'blog-categories.edit' => 'Edit blog categories',
            'blog-categories.delete' => 'Delete blog categories',
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

    'customers' => [
        'label' => 'Customers',
        'permissions' => [
            'customers.view' => 'View customers',
            'customers.edit' => 'Edit customers',
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

    'store_settings' => [
        'label' => 'Store Settings',
        'permissions' => [
            'store-settings.view' => 'View store settings',
            'store-settings.edit' => 'Edit store settings',
        ],
    ],
];