<?php 

declare(strict_types=1);

namespace WP_Rocket_e2e\App;

use League\Container\ServiceProvider\AbstractServiceProvider;
use WP_Rocket_e2e\App\Assets\Assets;
use WP_Rocket_e2e\App\Assets\Subscriber as AssetsSubscriber;

use WP_Rocket_e2e\App\Admin\Template;
use WP_Rocket_e2e\App\Modules\Cache\Cache;
use WP_Rocket_e2e\App\Admin\Pages;
use WP_Rocket_e2e\App\Admin\Notices;
use WP_Rocket_e2e\App\Admin\Subscriber as AdminSubscriber;

class ServiceProvider extends AbstractServiceProvider {

    public function provides( string $id ) : bool
    {
        $services = [
            'assets',
            'assets_subscriber',
            'template',
            'pages',
            'admin_subscriber',
            'cache',
            'notices',
        ];
        
        return in_array( $id, $services );
    }

    public function register() : void
    {
        $this->getContainer()->add( 'assets', Assets::class );

        $this->getContainer()->add( 'assets_subscriber', AssetsSubscriber::class )
        ->addArgument( $this->getContainer()->get( 'config_assets' ) )
        ->addArgument( $this->getContainer()->get( 'assets' ) );

        $this->getContainer()->add( 'template', Template::class );
        $this->getContainer()->add( 'cache', Cache::class );

        $this->getContainer()->add( 'pages', Pages::class )
        ->addArgument( $this->getContainer()->get( 'template' ) )
        ->addArgument( $this->getContainer()->get( 'cache' ) );

        $this->getContainer()->add( 'notices', Notices::class );

        $this->getContainer()->add( 'admin_subscriber', AdminSubscriber::class )
        ->addArgument( $this->getContainer()->get( 'pages' ) )
        ->addArgument( $this->getContainer()->get( 'notices' ) );
    }
}