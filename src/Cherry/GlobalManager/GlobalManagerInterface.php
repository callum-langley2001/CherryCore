<?php

declare(strict_types=1);

namespace Cherry\GlobalManager;

/**
 * Interface GlobalManagerInterface
 * 
 * @package Cherry
 * @subpackage GlobalManager
 * @author Callum Langley <callumlangley9@gmail.com>
 * @license MIT
 * @version 1.0.0
 * @since 1.0.0
 */
interface GlobalManagerInterface
{
    /**
     * Get global
     *
     * @param string $key The key to set
     * @param mixed $default The default value
     * @return void Nothing
     */
    public static function set(string $key, mixed $value): void;

    /**
     * Get global
     *
     * @param string $key The key to get
     * @return mixed The value
     */
    public static function get(string $key): mixed;
}