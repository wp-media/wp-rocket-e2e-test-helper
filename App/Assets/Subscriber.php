<?php
declare(strict_types=1);

namespace WP_Rocket_e2e\App\Assets;

use WP_Rocket_e2e\Events\Subscriber_Interface;

/**
 * Assets Subscriber.
 */
class Subscriber implements Subscriber_Interface {

    /**
     * Assets config.
     *
     * @var array
     */
    protected $config_assets = [];

    /**
     * Assets instance.
     *
     * @var Assets
     */
    protected $assets;

    /**
     * Instatiate class
     *
     * @param array $config_assets Array of assets config.
     * @param Assets $assets Assets instance.
     * @return void
     */
    public function __construct( array $config_assets, Assets $assets ) {
        $this->config_assets = $config_assets;
        $this->assets = $assets;
    }

	/**
	 * Returns array of events this listen to.
	 *
	 * @return array
	 */
	public static function get_subscribed_events() : array {
		return [
			'admin_enqueue_scripts' => [
                [ 'register_styles' ],
                [ 'register_scripts' ],
            ],
		];
	}

    /**
     * Register styles.
     *
     * @return void
     */
    public function register_styles() : void {
        if ( 'tools_page_' . CONFIG['PLUGIN_ID'] !== get_current_screen()->id ) {
            return;
        }

        if ( ! isset( $this->config_assets['styles'] ) ) {
            return;
        }

        $this->assets->register_styles( $this->config_assets['styles'] );
    }

    /**
     * Register scripts.
     *
     * @return void
     */
    public function register_scripts() : void {
        if ( 'tools_page_' . CONFIG['PLUGIN_ID'] !== get_current_screen()->id ) {
            return;
        }

        if ( ! isset( $this->config_assets['scripts'] ) ) {
            return;
        }

        $this->assets->register_scripts( $this->config_assets['scripts'] );
    }
}
