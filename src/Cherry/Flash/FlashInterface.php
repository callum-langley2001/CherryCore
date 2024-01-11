<?php

declare(strict_types=1);

namespace Cherry\Flash;

use Cherry\Flash\FlashTypes;

/**
 * Interface FlashInterface
 * 
 * @package Cherry
 * @subpackage Flash
 * @author Callum Langley <callumlangley9@gmail.com>
 * @license MIT
 * @version 1.0.0
 * @since 1.0.0
 */
interface FlashInterface
{
    /**
     * Add a flash message
     * 
     * @param string $message The message
     * @param string $type (Optional) The type
     * @return void
     */
    public static function add(string $message, string $type = FlashTypes::SUCCESS): void;

    /**
     * Get the flash message
     * 
     * @return mixed The flash message
     */
    public static function get(): mixed;
}
