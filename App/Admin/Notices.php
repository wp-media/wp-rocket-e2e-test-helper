<?php

namespace WP_Rocket_e2e\App\Admin;

/**
 * Handles Notices.
 */
class Notices {

    /**
     * Trigger notice if error in debug.log is related to wp-rocket.
     *
     * @return void
     */
    public function debug_log_notice() : void {
        if ( ! defined( 'WP_DEBUG' ) || ! defined( 'WP_DEBUG_LOG' ) || false === WP_DEBUG || false === WP_DEBUG_LOG ) {
            return;
        }

        $file_system = rocket_direct_filesystem();

        if ( ! $file_system->exists( WP_CONTENT_DIR . '/debug.log' ) ) {
            return;
        }

        $content = $file_system->get_contents( WP_CONTENT_DIR . '/debug.log' );

        if ( ! preg_match( '#plugins/wp-rocket#', $content ) ) {
            return;
        }

        $data = [
            'id' => 'debug_log_notice',
            'status' => 'error',
            'message' => 'WP Rocket has some related warnings/errors in debug.log',
        ];

        $this->display_notice( $data );
    }

    /**
     * Display Notice.
     *
     * @param array $notice_data Notice data.
     * @return void
     */
    public function display_notice( array $notice_data = [] ) : void {
        if ( ! empty( $notice_data ) ) {
            $data = $notice_data;
        }
        
        require_once CONFIG[ 'PLUGIN_PATH' ] . 'views/templates/notices.php';
    }
}
