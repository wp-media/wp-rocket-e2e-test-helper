<?php

/**
 * Retrieve single option.
 *
 * @param string $option Single option name.
 * @return mixed|null The option value, or null if not found.
 */
function rocket_e2e_get_option( string $option ) {
    $options = get_option( CONFIG['PLUGIN_OPTION'] );
    if ( ! $options || ! is_array( $options ) ) {
        return null;
    }

    return $options[ $option ] ?? null;
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