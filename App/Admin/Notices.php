<?php

namespace WP_Rocket_e2e\App\Admin;

/**
 * Handles Notices.
 */
class Notices {

    /**
     * Array of patterns to match WP Rocket related errors in debug.log.
     *
     * @var array
     */
    private $debug_log_patterns = [
        '/plugins/wp-rocket/',
        'WP_Rocket',
    ];

    /**
     * Array of WP Rocket related error patterns to exclude.
     *
     * @var array
     */
    private $debug_log_exclusion_patterns = [
        'wp-rocket/inc/Dependencies/Database',
        'WP_Rocket(.*)Table->create',
        'wp-rocket/inc/Engine/Common/Database/Queries/AbstractQuery',
        'Failed opening(.*?)wp-rocket/',
    ];

    /**
     * Trigger notice if error in debug.log is related to wp-rocket.
     *
     * @return void
     */
    public function debug_log_notice() : void {
        $display_error_notice = true;

        if ( ! defined( 'WP_DEBUG' ) || ! defined( 'WP_DEBUG_LOG' ) || false === WP_DEBUG || false === WP_DEBUG_LOG ) {
            return;
        }

        $file_system = rocket_e2e_direct_filesystem();

        if ( ! $file_system->exists( WP_CONTENT_DIR . '/debug.log' ) ) {
            return;
        }

        $content = $file_system->get_contents( WP_CONTENT_DIR . '/debug.log' );
        preg_match_all( '#^\[(?<timestamp>.*?)\] (?<error>.+?)(?=\n\[|\z)#ms', $content, $matches, PREG_SET_ORDER);

        // Flag errors related to WP Rocket in log.
        $wpr_related_errors = [];
        $patterns = implode( '|', $this->debug_log_patterns );

        foreach( $matches as $match ) {
            if ( ! preg_match( '#' . $patterns . '#', $match['error'] ) ) {
                continue;
            }

            // Store errors.
            $wpr_related_errors[] = $match['error'];
        }

        // Bail if no WP Rocket related error.
        if ( empty( $wpr_related_errors ) ) {
            return;
        }
       
        /**
         * Filters WP Rocket related errors to be excluded.
         * 
         * @param array $exclusion_patterns Array of WP Rocket related error patterns to exclude.
         */
        $exclusion_patterns = apply_filters( 'rocket_e2e_error_exclusions', $this->debug_log_exclusion_patterns );

        // Validate filter return.
        if ( ! is_array( $exclusion_patterns ) || empty( $exclusion_patterns ) ) {
            $exclusion_patterns =  $this->debug_log_exclusion_patterns;
        }

        $exclusion_patterns = implode( '|', $exclusion_patterns );

        // Check if errors should be excluded from notice.
        foreach( $wpr_related_errors as $errors ) {
            if ( preg_match( '#' . $exclusion_patterns . '#', $errors ) ) {
                $display_error_notice = false;

                continue;
            }

            $display_error_notice = true;
        }

        if ( ! $display_error_notice ) {
            return;
        }

        $data = [
            'id' => 'wpr_debug_log_notice',
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
