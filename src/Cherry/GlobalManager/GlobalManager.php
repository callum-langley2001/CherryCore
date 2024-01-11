<?php

declare(strict_types=1);

namespace Cherry\GlobalManager;

use Cherry\GlobalManager\Exception\GlobalManagerInvalidArgumentException;
use Cherry\GlobalManager\Exception\GlobalManagerException;
use Cherry\GlobalManager\GlobalManagerInterface;
use Throwable;

/**
 * Class GlobalManager
 * 
 * @package Cherry
 * @subpackage GlobalManager
 * @author Callum Langley <callumlangley9@gmail.com>
 * @license MIT
 * @version 1.0.0
 * @since 1.0.0
 * @implements GlobalManagerInterface
 * @see GlobalManagerInterface
 */
class GlobalManager implements GlobalManagerInterface
{
    /**
     * Sets the value of a key in the global variable array.
     *
     * @param string $key The key to set in the global variable array.
     * @param mixed $value The value to set for the given key.
     * @throws GlobalManagerException If an error occurs while setting the value.
     * @return void
     */
    public static function set(string $key, mixed $value): void
    {
        $GLOBALS[$key] = $value;
    }

    /**
     * Retrieves the value of a global variable based on the given key.
     *
     * @param string $key The key of the global variable to retrieve.
     * @throws GlobalManagerException An error occurred while getting the global variable.
     * @return mixed The value of the global variable.
     */
    public static function get(string $key): mixed
    {
        self::isGlobalValid($key);
        try {
            return $GLOBALS[$key];
        } catch (Throwable $th) {
            throw new GlobalManagerException('An error occurred while getting the global variable.');
        }
    }

    /**
     * Checks if a global variable with the given key is valid.
     *
     * @param string $key The key of the global variable to check.
     * @throws GlobalManagerInvalidArgumentException If the global key is not valid or empty.
     * @return void
     */
    private static function isGlobalValid(string $key): void
    {
        if (!isset($GLOBALS[$key])) {
            throw new GlobalManagerInvalidArgumentException("This global key is not valid. Please ensure that you have set a global with the key: {$key}");
        }
        if (empty($GLOBALS[$key])) {
            throw new GlobalManagerInvalidArgumentException('Please enter a value. Key is empty');
        }
    }
}
