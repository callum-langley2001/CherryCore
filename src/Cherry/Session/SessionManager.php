<?php

declare(strict_types=1);

namespace Cherry\Session;

use Cherry\Session\SessionFactory;

/**
 * SessionManager class
 * This class is used to manage Session objects.
 * 
 * @package Cherry
 * @subpackage Session
 * @author Callum Langley <callumlangley9@gmail.com>
 * @license MIT
 * @version 1.0.0
 * @since 1.0.0
 */
class SessionManager
{
    /**
     * Initializes the function.
     *
     * @return mixed
     */
    public function init(): mixed
    {
        $factory = new SessionFactory();
        return $factory->create(
            '',
            \Cherry\Session\Storage\NativeSessionStorage::class,
            []
        );
    }
}
