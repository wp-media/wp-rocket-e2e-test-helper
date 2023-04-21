<?php 

declare(strict_types=1);

namespace WP_Rocket_e2e\App\Modules;

use League\Container\ServiceProvider\AbstractServiceProvider;

use WP_Rocket_e2e\App\Modules\Cache\Subscriber as CacheSubscriber;

class ServiceProvider extends AbstractServiceProvider {

    public function provides( string $id ) : bool
    {
        $services = [
            'cache_subscriber',
        ];
        
        return in_array( $id, $services );
    }

    public function register() : void
    {
        $this->getContainer()->add( 'cache_subscriber', CacheSubscriber::class );
    }
}