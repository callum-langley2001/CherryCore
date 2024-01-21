<?php

declare(strict_types=1);

namespace Cherry\ErrorHandling;

use Cherry\Base\BaseView;
use ErrorException;

/**
 * Class ErrorHandling
 *
 * @package Cherry
 * @subpackage ErrorHandling
 * @author Callum Langley <callumlangley9@gmail.com>
 * @license MIT
 * @version 1.0.0
 * @since 1.0.0
 */
class ErrorHandling
{
    /**
     * Error handler function that throws an ErrorException.
     *
     * @param int $severity The severity level of the error
     * @param string $message The error message
     * @param string $file The file where the error occurred
     * @param int $line The line number where the error occurred
     * @throws ErrorException Exception thrown when there is an error
     * @return void
     */
    public static function errorHandler(
        $severity,
        $message,
        $file,
        $line
    ): void {
        if (!(error_reporting() && $severity)) return;

        throw new ErrorException($message, 0, E_ERROR, $file, $line);
    }

    public static function exceptionHandler($exception)
    {
        $code = $exception->getCode();

        if ($code != 404) $code = 500;

        http_response_code($code);

        $error = true;
        if ($error) {
            echo '<h1>Fatal Error</h1>' . PHP_EOL;
            echo '<p> Uncaught exception: ' . get_class($exception) . '</p>' . PHP_EOL;
            echo '<p> Message: ' . $exception->getMessage() . '</p>' . PHP_EOL;
            echo '<p> Stack trace: ' . $exception->getTraceAsString() . '</p>' . PHP_EOL;
            echo '<p>Thrown in ' . $exception->getFile() . ' on line ' . $exception->getLine() . '</p>' . PHP_EOL;
        } else {
            $errorLog = LOG_DIR . '/' . date('Y-m-d') . '.log';
            ini_set('error_log', $errorLog);
            $message = '[' . date('Y-m-d H:i:s') . '] Uncaught exception: ' . get_class($exception);
            $message .= ' with message ' . $exception->getMessage() . PHP_EOL;
            $message .= 'Stack trace: ' . $exception->getTraceAsString() . PHP_EOL;
            $message .= 'Thrown in ' . $exception->getFile() . ' on line ' . $exception->getLine();

            error_log($message);

            echo (new BaseView())->getTemplate("error/{$code}.php.twig", ['error_message' => $message]);
        }
    }
}
