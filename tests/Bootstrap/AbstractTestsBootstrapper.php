<?php

namespace AvtoDev\BackendToFrontendVariablesStack\Tests\Bootstrap;

use TypeError;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;
use Symfony\Component\Console\Output\ConsoleOutput;
use AvtoDev\BackendToFrontendVariablesStack\Tests\Traits\CreatesApplicationTrait;

abstract class AbstractTestsBootstrapper
{
    use CreatesApplicationTrait;

    /**
     * Prefix for 'magic' bootstrap methods.
     */
    const MAGIC_METHODS_PREFIX = 'boot';

    /**
     * @var Application
     */
    protected $app;

    /**
     * @var Filesystem
     */
    protected $files;

    /**
     * Constructor.
     *
     * @throws Exception
     */
    public function __construct()
    {
        set_exception_handler(function ($e) {
            if ($e instanceof Exception || $e instanceof TypeError) {
                echo sprintf(
                    'Exception: "%s" (file: %s, line: %d)' . PHP_EOL,
                    $e->getMessage(),
                    $e->getFile(),
                    $e->getLine()
                );
            }
            exit(100);
        });

        $this->app = $this->createApplication();

        $this->files = $this->app->make('files');

        // Rebuild names of methods of its own class
        foreach (get_class_methods(static::class) as $method_name) {
            // Еf method begins from substring 'boot'
            if (Str::startsWith($method_name, static::MAGIC_METHODS_PREFIX)) {
                // Then call the method by passing an array of collections to it (although it is not necessary to pass it)
                if (call_user_func_array([$this, $method_name], []) !== true) {
                    throw new Exception(sprintf(
                        'Bootstrap method "%s" has non-true result. So, we cannot start tests for this reason',
                        $method_name
                    ));
                }
            }
        }

        $this->log(null);

        restore_exception_handler();
    }

    /**
     * Show "styled" console message.
     *
     * @param string|null $message
     * @param string      $style
     */
    protected function log($message = null, $style = 'info')
    {
        /** @var ConsoleOutput|null $output */
        static $output = null;

        if (! ($output instanceof ConsoleOutput)) {
            $output = $this->app->make(ConsoleOutput::class);
        }

        $output->writeln(empty((string) $message)
            ? ''
            : sprintf('<%1$s>> Bootstrap:</%1$s> <%2$s>%3$s</%2$s>', 'comment', $style, $message)
        );
    }
}
