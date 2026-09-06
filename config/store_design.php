<?php

return [
    'template' => [
        'option_name' => 'store_design.template',
        'default' => 'design-1',
    ],
    'templates' => [
        'design-1' => [
            'label' => 'Template Design 1',
            'pages' => [
                'home' => 'frontend.templates.design-1.home',
                'product_listing' => 'frontend.templates.design-1.product-listing',
                'product_details' => 'frontend.templates.design-1.product-details',
                'blog_listing' => 'frontend.templates.design-1.blog-listing',
                'blog_details' => 'frontend.templates.design-1.blog-details',
            ],
            'sections' => [
                'header' => 'frontend.components.header.design-1',
                'footer' => 'frontend.components.footer.design-1',
                'product_card' => 'frontend.components.product.card.design-1',
                'product_listing' => 'frontend.components.product.listing.design-1',
                'product_details' => 'frontend.components.product.details.design-1',
                'blog_card' => 'frontend.components.blog.card.design-1',
                'blog_listing' => 'frontend.components.blog.listing.design-1',
                'blog_details' => 'frontend.components.blog.details.design-1',
            ],
        ],
        'design-2' => [
            'label' => 'Template Design 2',
            'pages' => [
                'home' => 'frontend.templates.design-2.home',
                'product_listing' => 'frontend.templates.design-2.product-listing',
                'product_details' => 'frontend.templates.design-2.product-details',
                'blog_listing' => 'frontend.templates.design-2.blog-listing',
                'blog_details' => 'frontend.templates.design-2.blog-details',
            ],
            'sections' => [
                'header' => 'frontend.components.header.design-2',
                'footer' => 'frontend.components.footer.design-2',
                'product_card' => 'frontend.components.product.card.design-2',
                'product_listing' => 'frontend.components.product.listing.design-2',
                'product_details' => 'frontend.components.product.details.design-2',
                'blog_card' => 'frontend.components.blog.card.design-2',
                'blog_listing' => 'frontend.components.blog.listing.design-2',
                'blog_details' => 'frontend.components.blog.details.design-2',
            ],
        ],
    ],
    'sections' => [
        'header' => [
            'label' => 'Header',
            'option_name' => 'store_design.header',
        ],
        'footer' => [
            'label' => 'Footer',
            'option_name' => 'store_design.footer',
        ],
        'product_card' => [
            'label' => 'Product Card',
            'option_name' => 'store_design.product_card',
        ],
        'product_listing' => [
            'label' => 'Product Listing',
            'option_name' => 'store_design.product_listing',
        ],
        'product_details' => [
            'label' => 'Product Details',
            'option_name' => 'store_design.product_details',
        ],
        'blog_card' => [
            'label' => 'Blog Card',
            'option_name' => 'store_design.blog_card',
        ],
        'blog_listing' => [
            'label' => 'Blog Listing',
            'option_name' => 'store_design.blog_listing',
        ],
        'blog_details' => [
            'label' => 'Blog Details',
            'option_name' => 'store_design.blog_details',
        ],
    ],
];