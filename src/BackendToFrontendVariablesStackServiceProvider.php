<?php

namespace AvtoDev\BackendToFrontendVariablesStack;

use Illuminate\Support\ServiceProvider;
use AvtoDev\BackendToFrontendVariablesStack\Contracts\BackendToFrontendVariablesInterface;
use AvtoDev\BackendToFrontendVariablesStack\Service\BackendToFrontendVariablesStack;

/**
 * Service registration.
 */
class BackendToFrontendVariablesStackServiceProvider extends ServiceProvider
{
    /**
     * Boot method.
     *
     * @return void
     */
    public function boot()
    {
        $this->initializeConfigs();
        $this->initializeAssets();

        $this->registerHelpers();
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            BackendToFrontendVariablesInterface::class,
            BackendToFrontendVariablesStack::class
        );
    }


    /**
     * Gets config key name.
     *
     * @return string
     */
    protected static function getConfigRootKeyName()
    {
        return basename(static::getConfigPath(), '.php');
    }

    /**
     * Get config file path.
     *
     * @return string
     */
    protected static function getConfigPath()
    {
        return __DIR__ . '/config/back2front.php';
    }

    /**
     * Get assets path.
     *
     * @return string
     */
    protected static function getAssetsDirPath()
    {
        return __DIR__.'/assets';
    }

    /**
     * Register helpers file.
     */
    protected function registerHelpers()
    {
        require __DIR__ . '/helpers.php';
    }

    /**
     * Initialize configs.
     *
     * @return void
     */
    protected function initializeConfigs()
    {
        $this->mergeConfigFrom(static::getConfigPath(), static::getConfigRootKeyName());

        $this->publishes([
            \realpath(static::getConfigPath()) => config_path(\basename(static::getConfigPath())),
        ], 'config');
    }

    /**
     * Initialize assets.
     *
     * @return void
     */
    protected function initializeAssets()
    {
        $this->publishes([
            \realpath(static::getAssetsDirPath()) => public_path('vendor/back2front'),
        ], 'assets');
    }
}
