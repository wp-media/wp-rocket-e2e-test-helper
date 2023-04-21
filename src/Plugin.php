<?php

namespace WP_Rocket_e2e;

use League\Container\Container;
use WP_Rocket_e2e\Events\Event_Manager;
use WP_Rocket_e2e\App\ServiceProvider as AssetsServiceProvider;
use WP_Rocket_e2e\App\Modules\ServiceProvider as ModulesServiceProvider;
use WP_Rocket_e2e\App\Activation_Deactivation;

class Plugin extends Activation_Deactivation {
    protected $container;

    protected $event_manager;

    public function __construct( array $config_assets, Container $container ) {
        $this->container = $container;

        $this->container->add( 'config_assets', $config_assets );
    }

    public function run() : void {
        $this->event_manager = new Event_Manager();
		$this->container->add( 'event_manager', $this->event_manager )->setShared();

        $this->filter_subscribers();
        $this->container->addServiceProvider( new AssetsServiceProvider );
        $this->container->addServiceProvider( new ModulesServiceProvider );

        foreach ( Subscriber::get() as $subscriber ) {
            $this->event_manager->add_subscriber( $this->container->get( $subscriber ) );
        }

        register_activation_hook( CONFIG['PLUGIN_FILE'], [ $this, 'activate' ] );
        register_deactivation_hook( CONFIG['PLUGIN_FILE'], [ $this, 'deactivate' ] );
    }

    private function filter_subscribers() : void {
        require_once CONFIG[ 'PLUGIN_PATH' ] . 'subscribers/admin.php';
    }
}