<?php
namespace WP_Rocket_e2e\App;

/**
 * Activation/Deactivation processes.
 */
class Activation_Deactivation {
    
    /**
     * Fires process when plugin is activated.
     *
     * @return void
     */
    public function activate() : void {
        $defaults = [
            'rocket_post_purge_urls' => 'default',
            'rocket_exclude_post_taxonomy' => 'default',
            'rocket_rocket_insights_enabled' => 'false_return',
        ];

        $existing_config = get_option( CONFIG['PLUGIN_OPTION'], [] );
        
        // Only keep existing non-empty values, otherwise use defaults
        foreach ( $defaults as $key => $default_value ) {
            if ( ! isset( $existing_config[ $key ] ) || $existing_config[ $key ] === '' || $existing_config[ $key ] === false ) {
                $existing_config[ $key ] = $default_value;
            }
        }
        
        update_option( CONFIG['PLUGIN_OPTION'], $existing_config );
    }

    /**
     * Fires process when plugin is deactivated.
     *
     * @return void
     */
    public function deactivate() : void {
        delete_option( CONFIG['PLUGIN_OPTION'] );
    }
}