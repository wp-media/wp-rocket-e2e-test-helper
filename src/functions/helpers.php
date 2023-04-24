<?php

/**
 * Retrieve single option.
 *
 * @param string $option Single option name.
 * @return void
 */
function __get_option( string $option ) {
    if ( ! get_option( CONFIG['PLUGIN_OPTION'] ) ) {
        return false;
    }

    $options = get_option( CONFIG['PLUGIN_OPTION'] );
    return $options[ $option ] ?? false;
}

/**
 * Check if WP Rocket is active.
 *
 * @return boolean
 */
function is_wpr_active() : bool {
    return defined( 'WP_ROCKET_VERSION' );
}