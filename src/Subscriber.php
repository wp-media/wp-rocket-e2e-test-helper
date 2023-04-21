<?php

namespace WP_Rocket_e2e;

trait Subscriber{

    /**
     * Array of service alias.
     *
     * @var array
     */
    public static $aliases = [];

    /**
     * Register Service alias
     *
     * @param mixed $aliases service aliaxes array|string
     * @return void
     */
    public static function register( $aliases ) : void {
        if ( is_array( $aliases ) ) {
            foreach ( $aliases as $alias ) {
                if ( in_array( $alias, self::$aliases ) ) {
                    continue;
                }

                self::$aliases[] = $alias;
            }
        }
        else {
            if ( ! in_array( $aliases, self::$aliases ) ) {
                self::$aliases[] = $aliases;
            }
        }
    }

    /**
     * Get service alias array.
     *
     * @return array
     */
    public static function get() : array {
        if ( empty( self::$aliases ) ) {
            return [];
        }

        return self::$aliases;
    }
}