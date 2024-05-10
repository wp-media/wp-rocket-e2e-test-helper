<?php

/**
 * Retrieve single option.
 *
 * @param string $option Single option name.
 * @return void
 */
function rocket_e2e_get_option( string $option ) {
    if ( ! get_option( CONFIG['PLUGIN_OPTION'] ) ) {
        return false;
    }

    $options = get_option( CONFIG['PLUGIN_OPTION'] );
    return $options[ $option ] ?? false;
}

function rocket_e2e_direct_filesystem() {
    require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php';
    require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php';
    return new WP_Filesystem_Direct( new StdClass() );
}

/**
 * Check if WP Rocket is active.
 *
 * @return boolean
 */
function is_wpr_active() : bool {
    return defined( 'WP_ROCKET_VERSION' );
}