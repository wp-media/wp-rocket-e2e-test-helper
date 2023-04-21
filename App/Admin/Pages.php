<?php

namespace WP_Rocket_e2e\App\Admin;

use WP_Rocket_e2e\App\Modules\Cache\Cache;

/**
 * Handle pages view.
 */
class Pages {
    /**
     * Template instance.
     *
     * @var Template
     */
    protected $template;

    /**
     * Cache instance.
     *
     * @var Cache
     */
    protected $cache;

    /**
     * Module views.
     *
     * @var array Array of modules view.
     */
    protected $views = [];

    /**
     * Instatiate class
     *
     * @param Template $template Template instance.
     * @return void
     */
    public function __construct( Template $template, Cache $cache ) {
        $this->template = $template;
        $this->cache = $cache;
    }

    /**
     * Load main view.
     *
     * @return void
     */
    public function render_views() : void {
        $this->cache_view();

        // Load modules to view.
        $this->views = $this->template->modules;
        require_once CONFIG[ 'PLUGIN_PATH' ] . 'views/main.php';
    }

    /**
     * Load all cache related test cases.
     *
     * @return void
     */
    private function cache_view() : void {
        $cache_logged_user = $this->cache->cache_logged_user();
        $this->template->add_test_case(
            'cache',
            'should_generate_cache_files_for_logged-in_users',
            'Should generate cache files for logged-in users',
            [
                'text' =>  $cache_logged_user ? 'Caching for logged-in user is enabled' : 'Caching for logged-in user is disabled',
                'type' => $cache_logged_user ? 'success' : 'warning',
            ],
            $this->cache->is_cache_generated( true )
        );

        $this->template->add_test_case(
            'cache',
            'should_generate_cache_files',
            'Should generate cache files for page visitors',
            [
                'text' => 'Visitors common cache',
                'type' => 'info',
            ],
            $this->cache->is_cache_generated()
        );

        $is_common_cache_enabled = $this->cache->is_common_cache_enabled();
        $this->template->add_test_case(
            'cache',
            'should_use_same_cache_set_user_when_common_cache_is_enabled',
            'Should use the same cache set for each user when common cache is enabled (Homepage Test)',
            [
                'text' => $is_common_cache_enabled ? 'Common cache is enabled' : 'Common cache is disabled',
                'type' => $is_common_cache_enabled ? 'success' : 'warning',
            ],
            $this->cache->is_common_cache_dir_used_for_users()
        );
    }
}
