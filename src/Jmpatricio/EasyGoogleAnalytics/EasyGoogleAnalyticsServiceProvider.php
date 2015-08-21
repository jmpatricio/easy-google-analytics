<?php

namespace Jmpatricio\EasyGoogleAnalytics;

use Illuminate\Support\ServiceProvider;

/**
 * Class EasyGoogleAnalyticsServiceProvider
 *
 * @since 1.0
 */
class EasyGoogleAnalyticsServiceProvider extends ServiceProvider
{

    /**
     * Package name
     */
    const PKG_NAME = 'easy-google-analytics';

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('jmpatricio/' . self::PKG_NAME);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        return;
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

}
