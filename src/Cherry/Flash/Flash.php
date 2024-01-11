<?php

declare(strict_types=1);

namespace Cherry\Flash;

use Cherry\GlobalManager\GlobalManager;
use Cherry\Flash\FlashInterface;
use Cherry\Flash\FlashTypes;

/**
 * Class Flash
 * 
 * @package Cherry
 * @subpackage Flash
 * @author Callum Langley <callumlangley9@gmail.com>
 * @license MIT
 * @version 1.0.0
 * @since 1.0.0
 * @implements FlashInterface
 * @see FlashInterface
 */
class Flash implements FlashInterface
{
    /**
     * The flash key
     * 
     * @var string $FLASH_KEY The flash key
     */
    protected const FLASH_key = 'flash_message';

    /**
     * Adds a flash message to the session.
     *
     * @param string $message The message to be displayed.
     * @param string $type The type of message (default: 'success').
     * @return void
     */
    public static function add(string $message, string $type = FlashTypes::SUCCESS): void
    {
        $session = GlobalManager::get('global_session');

        if (!$session->has(self::FLASH_key)) {
            $session->set(self::FLASH_key, []);
        }

        $session->setArray(self::FLASH_key, [
            'message' => $message,
            'type' => $type
        ]);
    }

    public static function get(): mixed
    {
        $session = GlobalManager::get('global_session');
        $session->flush(self::FLASH_key);
    }
}
