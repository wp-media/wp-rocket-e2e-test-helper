<?php

namespace WP_Rocket_e2e\App\Admin;

/**
 * Creates the plugin view.
 */
class Template {

    /**
     * Array of Module views.
     *
     * @var array Array of WP Rocket Module views.
     */
    public $modules = [
        'cache' => [   
            'name' => 'Cache',
            'id' => 'cache',
            'pane' => 'cache_tab_pane',
        ],
        'file_optimization' => [
            'name' => 'File Optimization',
            'id' => 'file_optimization',
            'pane' => 'file_optimization_tab_pane',
        ],
        'media' => [
            'name' => 'Media',
            'id' => 'media',
            'pane' => 'media_tab_pane',
        ],
        'preload' => [
            'name' => 'Preload',
            'id' => 'preload',
            'pane' => 'preload_tab_pane',
        ],
        'advanced_rules' => [
            'name' => 'Advanced Rules',
            'id' => 'advanced_rules',
            'pane' => 'advanced_rules_tab_pane',
        ],
        'database' => [
            'name' => 'Database',
            'id' => 'database',
            'pane' => 'database_tab_pane',
        ],
        'cdn' => [
            'name' => 'CDN',
            'id' => 'cdn',
            'pane' => 'cdn_tab_pane',
        ],
        'heartbeat' => [
            'name' => 'Heartbeat',
            'id' => 'heartbeat',
            'pane' => 'heartbeat_pane',
        ],
        'addons' => [
            'name' => 'Addons',
            'id' => 'addons',
            'pane' => 'addons_pane',
        ],
        'filters' => [
            'name' => 'Filters',
            'id' => 'filters',
            'pane' => 'filters',
        ],
    ];

    /**
     * Hold form data.
     *
     * @var array
     */
    public $form_data = [];
    
    /**
     * Load module view.
     *
     * @param string $id module id.
     * @return void
     */
    public function load_view( string $id ): void {
        if ( ! $this->is_valid_module( $id ) ) {
            $id = 'cache';
        }

        $this->form_data = require CONFIG[ 'PLUGIN_PATH' ] . 'views/form_data.php';

        require_once CONFIG[ 'PLUGIN_PATH' ] . 'views/modules/' . $id . '.php';
    }

    /**
     * Check valid module.
     *
     * @param string $id module id.
     * @return boolean
     */
    private function is_valid_module( string $id ) : bool {
        foreach ( $this->modules as $module ) {
            if ( $id === $module['id'] ) {
                return true;
            }
        }

        return false;
    }

    /**
     * Add new test case.
     *
     * @param string $module WP Rocket Module.
     * @param string $test_case_id Test case ID.
     * @param string $test_name Name of test case.
     * @param string $filter Filter.
     * @return void
     */
    public function add_test_case( string $module, string $test_case_id, string $test_name, array $note = [], $filter = '' ) : void {
        $this->modules[ $module ]['test_cases'][ $test_case_id ] = [
                'name' => $test_name,
                'note' => $note,
                'result' => $filter
        ];
    }
}
