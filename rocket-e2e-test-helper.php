<?php
/**
 * Plugin Name: WP Rocket | E2E Test Helper
 * Description: Helps to run playwright e2e tests efficiently
 * Author:      WP Rocket Dev Team
 * Author URI:  http://wp-rocket.me/
 * License:     GNU General Public License v2 or later
 */

defined( 'ABSPATH' ) || exit;

require 'vendor/autoload.php';
require_once 'src/functions/helpers.php';

define( 'CONFIG', require_once 'config/app.php' );

$config_assets = require_once CONFIG[ 'PLUGIN_PATH' ] . 'config/assets.php';

$plugin = new WP_Rocket_e2e\Plugin( $config_assets, new League\Container\Container );

// Register activation/deactivation hooks at the top level
register_activation_hook( __FILE__, [ $plugin, 'activate' ] );
register_deactivation_hook( __FILE__, [ $plugin, 'deactivate' ] );

add_action( 'plugins_loaded', [ $plugin, 'run' ] );
