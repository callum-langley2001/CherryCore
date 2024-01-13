<?php

declare(strict_types=1);

namespace Cherry\Session;

use Cherry\Session\SessionFactory;
use Cherry\Yaml\YamlConfig;

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
     * Initializes the class.
     *
     * @return mixed
     */
    public static function init(): mixed
    {
        $factory = new SessionFactory();
        return $factory->create(
            'cherrycake',
            \Cherry\Session\Storage\NativeSessionStorage::class,
            YamlConfig::file('session.yaml')
        );
    }
}
