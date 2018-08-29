<?php

namespace AvtoDev\BackendToFrontendVariablesStack;

use Illuminate\Support\ServiceProvider;
use AvtoDev\BackendToFrontendVariablesStack\Contracts\BackendToFrontendVariablesInterface;
use AvtoDev\BackendToFrontendVariablesStack\Service\BackendToFrontendVariablesStack;
use Illuminate\View\Compilers\BladeCompiler;

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
    public function boot(BladeCompiler $blade)
    {
        $this->initializeConfigs();

        $this->registerHelpers();

        $this->initializeAssets();
        $this->publicationConfigs();

        /**
         * Директива для вывода тега установки данных в объект Window.
         */
        $blade->directive('back_to_front_data', function ($stack_name) {

            $stack_name = (! empty($stack_name))
                ? $stack_name
                : config('back2front.data_name');
            $stack_name = trim($stack_name, '\'"');


            $tag_text = '<script type="text/javascript">' .
                        'Object.defineProperty(window, "' . $stack_name . '", {' .
                        'writable: false,' .
                        ' value: ' . backToFrontStack()->toJson() .
                        '});' .
                        '</script>';

            return '<?php echo \'' . $tag_text . '\'; ?>';
        });
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
        return __DIR__ . '/assets';
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
    }

    /**
     * Publish configs.
     */
    protected function publicationConfigs()
    {
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
