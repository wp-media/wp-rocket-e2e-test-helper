<?php

namespace WP_Rocket_e2e\App\Assets;

/**
 * Defines plugin assets.
 */
class Assets {

    /**
     * Register styles.
     *
     * @param array $styles Array of styles to register.
     * @return void
     */
    public function register_styles( array $styles ) : void {
        foreach ( $styles as $handle => $src ) {
            wp_register_style( $handle, $src );
            wp_enqueue_style( $handle );
        }
    }

    /**
     * Register scripts.
     *
     * @param array $scripts Array of scripts to register.
     * @return void
     */
    public function register_scripts( array $scripts ) : void {
        foreach ( $scripts as $handle => $src ) {
            wp_register_script( $handle, $src, null, null, true );
            wp_enqueue_script( $handle );
        }
    }
}