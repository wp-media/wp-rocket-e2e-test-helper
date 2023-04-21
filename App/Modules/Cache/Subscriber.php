<?php

namespace WP_Rocket_e2e\App\Modules\Cache;

use WP_Rocket_e2e\Events\Subscriber_Interface;

/**
 * Cache Subscriber.
 */
class Subscriber implements Subscriber_Interface {

	/**
	 * Returns array of events this listen to.
	 *
	 * @return array
	 */
	public static function get_subscribed_events() : array {
		return [
            'rocket_post_purge_urls' => 'purge_urls',
            'rocket_exclude_post_taxonomy' => [ 'exclude_post_taxonomy', 12 ],
        ];
	}

    /**
     * Purge urls.
     *
     * @param array $purge_urls urls to purge.
     * @return array
     */
    public function purge_urls( array $purge_urls ) : array {
        if ( ! __get_option( 'rocket_post_purge_urls' ) ) {
            return $purge_urls;
        }

        $rocket_post_purge_urls = __get_option( 'rocket_post_purge_urls' );

        switch ( $rocket_post_purge_urls ) {
            case 'false_return':
                $purge_urls[] = false;
                break;
            case 'null_return':
                $purge_urls[] = null;
                break;
            case 'zero':
                $purge_urls[] = 0;
                break;
            case 'empty_string':
                $purge_urls[] = '';
                break;
            case 'float':
                $purge_urls[] = 2.5;
                break;
            case 'int':
                $purge_urls[] = 15;
                break;
            case 'invalid_array':
                $purge_urls = ['yy',0,True];
                break;
            case 'default':
                return $purge_urls;
            default:
                return $purge_urls;
        }

        return $purge_urls;
    }

    /**
     * Exclude post taxonomy for cache purge.
     *
     * @param array $taxonomies Array of taxonomies.
     * @return array
     */
    public function exclude_post_taxonomy( array $taxonomies ) : array {
        if ( ! __get_option( 'rocket_exclude_post_taxonomy' ) ) {
            return $taxonomies;
        }

        $rocket_exclude_post_taxonomy = __get_option( 'rocket_exclude_post_taxonomy' );

        if ( 'default' === $rocket_exclude_post_taxonomy ) {
            return $taxonomies;
        }
        
        $taxonomies[] = $rocket_exclude_post_taxonomy;

        return $taxonomies;
    }
}