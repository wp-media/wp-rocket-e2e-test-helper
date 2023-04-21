<?php
declare(strict_types=1);

namespace WP_Rocket_e2e\App\Admin;

use WP_Rocket_e2e\Events\Subscriber_Interface;

/**
 * Template Subscriber.
 */
class Subscriber implements Subscriber_Interface {

    /**
     * Pages instance.
     *
     * @var Pages
     */
    protected $pages;

    /**
     * Notices instance.
     *
     * @var Notices
     */
    protected $notices;

    /**
     * Plugin ID.
     *
     * @var string
     */
    private static $plugin_id = '';

    /**
     * Instatiate class
     *
     * @param Template $template Template instance.
     * @return void
     */
    public function __construct( Pages $pages, Notices $notices ) {
        $this->pages = $pages;
        $this->notices = $notices;
        self::$plugin_id = CONFIG['PLUGIN_ID'];
    }

	/**
	 * Returns array of events this listen to.
	 *
	 * @return array
	 */
	public static function get_subscribed_events() : array {
		return [
			'admin_menu' => 'admin_menu',
            'admin_notices' => 'debug_log_notice',
            'admin_post_' . self::$plugin_id . '_filters_form' => 'save_filter_returns',
            'admin_init' => [
                [ 'trap_response' ],
                [ 'set_response' ],
            ],
		];
	}

    /**
     * Add to admin menu.
     *
     * @return void
     */
    public function admin_menu() : void {
        add_management_page( 
            CONFIG['PLUGIN'], 
            CONFIG['PLUGIN'],
            'install_plugins',
            self::$plugin_id,
            [ $this->pages, 'render_views' ]
        );
    }

    /**
     * Display notice for wp rocket related warnings/errors in debug.log.
     *
     * @return void
     */
    public function debug_log_notice() : void {
        $this->notices->debug_log_notice();
    }

    /**
     * Process filter simulation
     *
     * @return void
     */
    public function save_filter_returns() : void {
        $nonce_field = self::$plugin_id . '_filters_form_nonce';

        if( isset( $_POST[ $nonce_field ] ) && wp_verify_nonce( $_POST[ $nonce_field ], $nonce_field ) ) {
            $rocket_post_purge_urls = sanitize_text_field( $_POST['rocket_post_purge_urls'] );
            $rocket_exclude_post_taxonomy = sanitize_text_field( $_POST['rocket_exclude_post_taxonomy'] );

            $wpr_e2e_config = get_option( 'wpr_e2e_config' );
            $wpr_e2e_config['rocket_post_purge_urls'] = $rocket_post_purge_urls;
            $wpr_e2e_config['rocket_exclude_post_taxonomy'] = $rocket_exclude_post_taxonomy;
            
            update_option( 'wpr_e2e_config', $wpr_e2e_config );

            $arg = [
                self::$plugin_id . '_response' => 'success',
            ];

            wp_redirect( esc_url_raw( add_query_arg( $arg, admin_url( 'tools.php?page='. self::$plugin_id ) ) ) );
            exit;
        }
    }

    /**
     * Set Feedback from form process.
     *
     * @return void
     */
    public function trap_response(): void {
        if ( ! isset( $_GET[ self::$plugin_id . '_response' ] ) ) {
            return;
        }

        switch ( $_GET[ self::$plugin_id . '_response' ] ) {
            case 'success':
                $value = [
                    'status' => 'success',
                    'response' => 'Settings updated',
                ];
                break;
            case 'failed':
                $value = [
                    'status' => 'error',
                    'response' => 'Unable to update settings',
                ];
                break;
            default:
                $value = [
                    'status' => 'success',
                    'response' => 'Settings updated',
                ];
        }

        set_transient( self::$plugin_id . '_response', $value, 3 );
        wp_redirect( esc_url_raw( admin_url( 'tools.php?page='. self::$plugin_id ) ) );
        exit;
    }

    /**
     * Set form response.
     *
     * @return void
     */
    public function set_response(): void {
        if ( false === get_transient( self::$plugin_id . '_response' ) ) {
            return;
        }

        $response = get_transient( self::$plugin_id . '_response' );

        add_settings_error(
            self::$plugin_id . '_response',
            esc_attr( 'response' ),
            $response['response'],
            $response['status']
        );
    }
}
