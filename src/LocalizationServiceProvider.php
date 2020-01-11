<?php

namespace Gecche\Cupparis\Localization;

use Illuminate\Support\ServiceProvider;

class LocalizationServiceProvider extends ServiceProvider {

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

	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app->singleton('localization', function($app)
        {
            return new Localization($app);
        });

	}

//	private function getDriverClass()
//	{
//		$provider = Config::get('acl::driver');
//		return 'Cupparis\Acl\PermissionDrivers\\' . ucfirst($provider) . 'Driver';
//	}

}
