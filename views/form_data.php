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
        'transient_wp_rocket_pricing' => [
            'form_data' => [
                'disabled' => 'disabled',
                'enabled' => 'enabled',
            ],
            'state' => rocket_e2e_get_option( 'transient_wp_rocket_pricing' ) ?? 'disabled',
        ],
        'transient_wp_rocket_customer_data_license_simulation' => [
            'form_data' => [
                'disabled' => 'disabled',
                'enabled' => 'enabled',
            ],
            'state' => rocket_e2e_get_option( 'transient_wp_rocket_customer_data_license_simulation' ) ?? 'disabled',
        ],

        'transient_wp_rocket_customer_data_license_type' => [
            'form_data' => [
                'default' => 'keep existing',
                '1' => '1 - single',
                '3' => '3 - plus',
                '50' => '50 - multi50',
                '100' => '100 - multi100',
                '500' => '500 - multi500',
                '-1' => '-1 - infinite',
            ],
            'state' => rocket_e2e_get_option( 'transient_wp_rocket_customer_data_license_type' ) ?? 'default',
        ],
        'transient_wp_rocket_customer_data_license_expiration' => [
            'form_data' => [
                'default' => 'keep existing',
                'not_expired' => 'not expired (+1 year)',
                'expiring_soon' => 'expiring soon (+5 days)',
                'expired' => 'expired (-1 month)',
            ],
            'state' => rocket_e2e_get_option( 'transient_wp_rocket_customer_data_license_expiration' ) ?? 'default',
        ],
        'transient_wp_rocket_customer_data_auto_renewal' => [
            'form_data' => [
                'default' => 'keep existing',
                'enabled' => 'enabled',
                'disabled' => 'disabled',
            ],
            'state' => rocket_e2e_get_option( 'transient_wp_rocket_customer_data_auto_renewal' ) ?? 'default',
        ],

        'nonce' => wp_create_nonce( CONFIG['PLUGIN_ID'] . '_filters_form_nonce' ),
    ],
];