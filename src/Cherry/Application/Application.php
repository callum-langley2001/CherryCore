<?php

declare(strict_types=1);

namespace Cherry\Application;

use Cherry\Traits\SystemTrait;
use Cherry\Application\Config;
use Cherry\Yaml\YamlConfig;

/**
 * Class Application
 *
 * @package Cherry
 * @subpackage Application
 * @author Callum Langley <callumlangley9@gmail.com>
 * @version 1.0.0
 * @since 1.0.0
 */
class Application
{
    /**
     * The application root
     * 
     * @var string $appRoot The application root
     */
    protected string $appRoot;

    /**
     * Creates a new instance of the class.
     *
     * @param string $appRoot The root directory of the application.
     */
    public function __construct(string $appRoot)
    {
        $this->appRoot = $appRoot;
    }

    /**
     * Runs the function and checks if the PHP version is compatible with the core version.
     *
     * @return self
     */
    public function run(): self
    {
        $this->constants();
        if (version_compare($phpVersion = PHP_VERSION, $coreVersion = Config::CHERRY_MIN_VERSION, '<')) {
            die(sprintf('Your PHP version (%s) is too old. The minimum version is %s.', $phpVersion, $coreVersion));
        }
        $this->environment();
        $this->errorHandler();

        return $this;
    }

    /**
     * Defines the constants used in the application.
     * 
     * @return void
     */
    private function constants(): void
    {
        defined('DS') || define('DS', DIRECTORY_SEPARATOR);
        defined('APP_ROOT') || define('APP_ROOT', $this->appRoot);
        defined('CONFIG_DIR') || define('CONFIG_DIR', APP_ROOT . DS . 'Config');
        defined('TEMPLATES_PATH') || define('TEMPLATES_PATH', APP_ROOT . DS . 'App' . DS . 'templates');
        defined('LOG_DIR') || define(('LOG_DIR'), APP_ROOT . DS . 'tmp' . DS . 'logs');
    }

    /**
     * Sets up the environment for the PHP function.
     *
     * @return void
     */
    private function environment(): void
    {
        ini_set('default_charset', 'UTF-8');
    }

    /**
     * Error handler for the PHP function.
     *
     * This function sets the error reporting level to include all errors and strict standards,
     * sets the error handler to a custom function, and sets the exception handler to a custom function.
     *
     * @return void
     */
    private function errorHandler(): void
    {
        error_reporting(E_ALL | E_STRICT);
        set_error_handler('Cherry\ErrorHandling\ErrorHandling::errorHandler');
        set_exception_handler('Cherry\ErrorHandling\ErrorHandling::exceptionHandler');
    }

    public function setSession()
    {
    }
}
