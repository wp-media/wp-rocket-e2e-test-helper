<?php

$license_credentials_file = __DIR__ . '/license-credentials.php';
$license_type_credentials = file_exists( $license_credentials_file ) ? ( require $license_credentials_file ) : [];

$local_license_credentials_file = __DIR__ . '/license-credentials.local.php';
if ( file_exists( $local_license_credentials_file ) ) {
    $local_credentials = require $local_license_credentials_file;
    if ( is_array( $local_credentials ) ) {
        $license_type_credentials = array_replace_recursive( $license_type_credentials, $local_credentials );
    }
}

return [
    // Plugin file.
    'PLUGIN_FILE' => ( $plugin_file = str_replace( 'config/app.php', 'rocket-e2e-test-helper.php', __FILE__ ) ),
    
    // Plugin path.
    'PLUGIN_PATH' => realpath( plugin_dir_path( $plugin_file ) ) . '/',

    // Plugin name.
    'PLUGIN' => 'Rocket E2E Tests',

    // Plugin ID.
    'PLUGIN_ID' => 'rocket_e2e_tests_helper',

    // Plugin URL.
    'PLUGIN_URL' => $plugin_url = plugin_dir_url( $plugin_file ),

    // Assets Path.
    'ASSETS_URL' => $plugin_url . 'assets/',

    // Plugin Option.
    'PLUGIN_OPTION' => 'wpr_e2e_config',

    // License credentials by type, read from config/license-credentials.php.
    'LICENSE_TYPE_CREDENTIALS' => is_array( $license_type_credentials ) ? $license_type_credentials : [],
];
