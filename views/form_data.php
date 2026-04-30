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
        'license_type_override' => [
            'form_data' => [
                'default'   => 'no change',
                'single'    => 'single',
                'plus'      => 'plus',
                'multi_50'  => 'multi 50',
                'multi_100' => 'multi 100',
                'multi_500' => 'multi 500',
            ],
            'state' => rocket_e2e_get_option( 'license_type_override' ) ?? 'default',
        ],
        'license_expiration_override' => [
            'form_data' => [
                'default'       => 'keep existing',
                'expired'       => 'expired (today -100 days)',
                'just_expired'  => 'just expired (today -2 days)',
                'expiring_soon' => 'expiring soon (today +4 days)',
                'not_expired'   => 'not expired (today +100 days)',
            ],
            'state' => rocket_e2e_get_option( 'license_expiration_override' ) ?? 'default',
        ],
        'license_creation_date_override' => [
            'form_data' => [
                'default' => 'keep existing',
                'created_2_days_ago' => 'just created (today -2 days)',
                'created_20_days_ago' => 'created (today -20 days)',
            ],
            'state' => rocket_e2e_get_option( 'license_creation_date_override' ) ?? 'default',
        ],
        // if auto renew is enabled, the just expired and expiring soon won't be displayed
        // while the promo and expired banner will be displayed
        'license_auto_renew_override' => [
            'form_data' => [
                'default' => 'keep existing',
                'false' => 'false',
                'true' => 'true',
            ],
            'state' => rocket_e2e_get_option( 'license_auto_renew_override' ) ?? 'default',
        ],

        'nonce' => wp_create_nonce( CONFIG['PLUGIN_ID'] . '_filters_form_nonce' ),
    ],
];