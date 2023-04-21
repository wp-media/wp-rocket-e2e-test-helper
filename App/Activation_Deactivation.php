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
        $config = [
            'rocket_post_purge_urls' => 'default',
            'rocket_exclude_post_taxonomy' => 'default',
        ];

        add_option( CONFIG['PLUGIN_OPTION'], $config );
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