<?php
defined( 'ABSPATH' ) || exit;

return [
    'form_action' => admin_url( 'admin-post.php' ),

    'filters' => [
        'rocket_post_purge_urls' => [
            'form_data' => [
                'default' => 'default',
                'false_return' => 'false',
                'null_return' => 'null',
                'zero' => '0',
                'empty_string' => '""',
                'float' => '2.5',
                'int' => '15',
                'invalid_array' => '["yy",0,True]',
            ],
            'state' => rocket_e2e_get_option( 'rocket_post_purge_urls' ) ?? '',
        ],
        'rocket_exclude_post_taxonomy' => [
            'form_data' => [
                'default' => 'default',
                'category' => 'category',
                'post_tag' => 'post_tag',
                'product_cat' => 'product_cat',
            ],
            'state' => rocket_e2e_get_option( 'rocket_exclude_post_taxonomy' ) ?? '',
        ],
        'rocket_rocket_insights_enabled' => [
            'form_data' => [
                'false_return' => 'false',
                'true_return' => 'true',
            ],
            'state' => rocket_e2e_get_option( 'rocket_rocket_insights_enabled' ) ?? 'false_return',
        ],

        'nonce' => wp_create_nonce( CONFIG['PLUGIN_ID'] . '_filters_form_nonce' ),
    ],
];