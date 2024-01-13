<?php

declare(strict_types=1);

namespace Cherry\Application;

/**
 * Class Config
 *
 * @package Cherry
 * @subpackage Application
 * @author Callum Langley <callumlangley9@gmail.com>
 * @version 1.0.0
 * @since 1.0.0
 */
class Config
{
    /**
     * The minimum version of Cherry required to run the application
     * 
     * @var string $CHERRY_MIN_VERSION The minimum version of Cherry required to run the application
     */
    public const CHERRY_MIN_VERSION = '7.4.12';

    /**
     * The version of the Cherry core
     * 
     * @var string $CHERRY_CORE_VERSION The version of the Cherry core
     */
    public const CHERRY_CORE_VERSION = '1.0.0';
}
