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
            'rocket_rocket_insights_enabled' => 'rocket_insights_enabled',
            'transient_wp_rocket_pricing' => [ 'transient_wp_rocket_pricing', 10 ],
            'transient_wp_rocket_customer_data' => [ 'transient_wp_rocket_customer_data_license_simulation', 11 ]
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

        if ( empty( $value ) ) {
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
     * Simulate license values in transient customer data.
     *
     * @param mixed $value Transient value.
     * @return mixed
     */
    public function transient_wp_rocket_customer_data_license_simulation( $value ) {
        $license_simulation = rocket_e2e_get_option( 'transient_wp_rocket_customer_data_license_simulation' );

        if ( 'enabled' !== $license_simulation ) {
            return $value;
        }

        if ( empty( $value ) || ! is_object( $value ) ) {
            return $value;
        }

        $this->apply_simulated_license_values_to_object( $value );

        return $value;
    }


    /**
     * Apply simulated license values to an object payload.
     *
     * @param object $value License payload object.
     * @return void
     */
    private function apply_simulated_license_values_to_object( object $value ) : void {
        $license_type = rocket_e2e_get_option( 'transient_wp_rocket_customer_data_license_type' );
        if ( ! empty( $license_type ) && 'default' !== $license_type ) {
            $value->licence_account = $license_type;
        }

        $license_name = $this->get_simulated_license_name();
        if ( null !== $license_name ) {
            if ( ! isset( $value->licence ) || ! is_object( $value->licence ) ) {
                $value->licence = (object) [];
            }

            $value->licence->name = $license_name;
        }

        $expiration = $this->get_simulated_license_expiration();
        if ( null !== $expiration ) {
            $value->licence_expiration = $expiration;
        }

        $auto_renewal = rocket_e2e_get_option( 'transient_wp_rocket_customer_data_auto_renewal' );
        if ( 'enabled' === $auto_renewal ) {
            $value->has_auto_renew = true;
        } elseif ( 'disabled' === $auto_renewal ) {
            $value->has_auto_renew = false;
        }
    }

    /**
     * Return simulated license expiration timestamp.
     *
     * @return int|null
     */
    private function get_simulated_license_expiration() {
        $expiration = rocket_e2e_get_option( 'transient_wp_rocket_customer_data_license_expiration' );

        switch ( $expiration ) {
            case 'expired':
                return strtotime( '-1 month' );
            case 'not_expired':
                return strtotime( '+1 year' );
            case 'expiring_soon':
                return strtotime( '+5 days' );
            default:
                return null;
        }
    }

    /**
     * Return simulated license name.
     *
     * @return string|null
     */
    private function get_simulated_license_name() {
        $license_name = rocket_e2e_get_option( 'transient_wp_rocket_customer_data_license_name' );

        switch ( $license_name ) {
            case 'single':
                return 'Single';
            case 'plus':
                return 'Plus';
            case 'multi_50':
                return 'Multi 50';
            case 'multi_100':
                return 'Multi 100';
            case 'multi_500':
                return 'Multi 500';
            case 'infinite':
                return 'Infinite';
            case 'empty':
            default:
                return '';
        }
    }
}
