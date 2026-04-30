<?php

namespace WP_Rocket_e2e\App\Modules\Cache;

use WP_Rocket_e2e\Events\Subscriber_Interface;

/**
 * Cache Subscriber.
 */
class Subscriber implements Subscriber_Interface {

    /**
     * Returns array of events this listens to.
     *
     * @return array
     */
    public static function get_subscribed_events() : array {
        return [
            'rocket_post_purge_urls' => 'purge_urls',
            'rocket_exclude_post_taxonomy' => [ 'exclude_post_taxonomy', 12 ],
            'rocket_rocket_insights_enabled' => 'rocket_insights_enabled',
            'transient_wp_rocket_pricing' => [ 'transient_wp_rocket_pricing', 10 ],
            'transient_wp_rocket_customer_data' => [ 'transient_wp_rocket_customer_data_license_override', 11 ],
            'pre_get_rocket_option_consumer_key' => 'pre_get_rocket_option_consumer_key',
            'pre_get_rocket_option_consumer_email' => 'pre_get_rocket_option_consumer_email',
        ];
    }

    /**
     * Override consumer key based on selected license type.
     *
     * @param mixed $value Existing option value.
     * @return mixed
     */
    public function pre_get_rocket_option_consumer_key( $value = '' ) {
        $credentials = $this->get_selected_license_credentials();
        if ( empty( $credentials['key'] ) ) {
            return $value;
        }

        return $credentials['key'];
    }

    /**
     * Override consumer email based on selected license type.
     *
     * @param mixed $value Existing option value.
     * @return mixed
     */
    public function pre_get_rocket_option_consumer_email( $value = '' ) {
        $credentials = $this->get_selected_license_credentials();
        if ( empty( $credentials['email'] ) ) {
            return $value;
        }

        return $credentials['email'];
    }

    /**
     * Return credentials for the selected license type, or empty array if none/default selected.
     *
     * @return array
     */
    private function get_selected_license_credentials() : array {
        $license_type = rocket_e2e_get_option( 'license_type_override' );
        if ( ! is_string( $license_type ) || '' === $license_type || 'default' === $license_type ) {
            return [];
        }

        $credentials_by_type = CONFIG['LICENSE_TYPE_CREDENTIALS'] ?? [];
        if ( ! is_array( $credentials_by_type ) || ! isset( $credentials_by_type[ $license_type ] ) ) {
            return [];
        }

        $credentials = $credentials_by_type[ $license_type ];
        if ( ! is_array( $credentials ) ) {
            return [];
        }

        return [
            'key'   => isset( $credentials['key'] ) ? (string) $credentials['key'] : '',
            'email' => isset( $credentials['email'] ) ? (string) $credentials['email'] : '',
        ];
    }

    /**
     * Purge urls.
     *
     * @param array $purge_urls urls to purge.
     * @return array
     */
    public function purge_urls( array $purge_urls ) : array {
        if ( ! rocket_e2e_get_option( 'rocket_post_purge_urls' ) ) {
            return $purge_urls;
        }

        $rocket_post_purge_urls = rocket_e2e_get_option( 'rocket_post_purge_urls' );

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
                $purge_urls = [ 'yy', 0, true ];
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
        if ( ! rocket_e2e_get_option( 'rocket_exclude_post_taxonomy' ) ) {
            return $taxonomies;
        }

        $rocket_exclude_post_taxonomy = rocket_e2e_get_option( 'rocket_exclude_post_taxonomy' );

        if ( 'default' === $rocket_exclude_post_taxonomy ) {
            return $taxonomies;
        }

        $taxonomies[] = $rocket_exclude_post_taxonomy;

        return $taxonomies;
    }

    /**
     * Enable or disable Rocket Insights.
     *
     * @param bool $enabled Whether Rocket Insights is enabled.
     * @return bool
     */
    public function rocket_insights_enabled( bool $enabled ) : bool {
        if ( ! rocket_e2e_get_option( 'rocket_rocket_insights_enabled' ) ) {
            return $enabled;
        }

        $rocket_rocket_insights_enabled = rocket_e2e_get_option( 'rocket_rocket_insights_enabled' );

        switch ( $rocket_rocket_insights_enabled ) {
            case 'false_return':
                return false;
            case 'true_return':
                return true;
            default:
                return $enabled;
        }
    }

    /**
     * Simulate active pricing promo in transient.
     *
     * @param mixed $value Transient value.
     * @return mixed
     */
    public function transient_wp_rocket_pricing( $value ) {
        $state = rocket_e2e_get_option( 'transient_wp_rocket_pricing' );

        if ( 'enabled' !== $state ) {
            return $value;
        }

        if ( empty( $value ) || ! is_object( $value ) ) {
            return $value;
        }

        $value->promo = (object) [
            'name'             => 'Test Summer Sale',
            'discount_percent' => 30,
            'start_date'       => strtotime( '-1 day' ),
            'end_date'         => strtotime( '+5 days' ),
        ];

        return $value;
    }

    /**
     * Override customer data license fields from UI selections.
     *
     * @param mixed $value Transient value.
     * @return mixed
     */
    public function transient_wp_rocket_customer_data_license_override( $value ) {
        if ( empty( $value ) || ! is_object( $value ) ) {
            return $value;
        }

        $date_created = $this->get_license_creation_date_override_timestamp();
        if ( null !== $date_created ) {
            $value->date_created = $date_created;
        }


        $expiration = $this->get_license_expiration_override_timestamp();
        if ( null !== $expiration ) {
            $value->licence_expiration = $expiration;
        }

        $auto_renew = rocket_e2e_get_option( 'license_auto_renew_override' );
        if ( 'true' === $auto_renew ) {
            $value->has_auto_renew = 1;
        }

        if ( 'false' === $auto_renew ) {
            $value->has_auto_renew = 0;
        }

        return $value;
    }

    /**
     * Return override expiration timestamp based on selected state.
     *
     * @return int|null
     */
    private function get_license_expiration_override_timestamp() {
        $expiration = rocket_e2e_get_option( 'license_expiration_override' );

        switch ( $expiration ) {
            case 'expired':
                return strtotime( '-100 days' );
            case 'not_expired':
                return strtotime( '+100 days' );
            case 'expiring_soon':
                return strtotime( '+4 days' );
            case 'just_expired':
                return strtotime( '-2 days' );
            default:
                return null;
        }
    }

    /**
     * Return override creation timestamp based on selected state.
     *
     * @return int|null
     */
    private function get_license_creation_date_override_timestamp() {
        $creation_date = rocket_e2e_get_option( 'license_creation_date_override' );

        switch ( $creation_date ) {
            case 'created_2_days_ago':
                return strtotime( '-2 days' );
            case 'created_20_days_ago':
                return strtotime( '-20 days' );
            default:
                return null;
        }
    }
}
