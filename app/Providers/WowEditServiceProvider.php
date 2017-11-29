<?php

namespace Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application;
use Laravel\Http\Controllers\Wow\WowEditController;

class WowEditServiceProvider extends ServiceProvider
{
	protected $defer = true;

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register(){
		\App::bind(
			'wowedit',
			'Laravel\Http\Controllers\Wow\WowEditController'
		);
	}
}