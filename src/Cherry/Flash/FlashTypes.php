<?php

declare(strict_types=1);

namespace Cherry\Flash;

/**
 * Class Flash
 * 
 * @package Cherry
 * @subpackage Flash
 * @author Callum Langley <callumlangley9@gmail.com>
 * @license MIT
 * @version 1.0.0
 * @since 1.0.0
 */
class FlashTypes
{
    /**
     * The success flash type
     * 
     * @var string $SUCCESS
     */
    public const SUCCESS = 'success';

    /**
     * The info flash type
     * 
     * @var string $INFO
     */
    public const INFO = 'info';

    /**
     * The warning flash type
     * 
     * @var string $WARNING
     */
    public const WARNING = 'warning';

    /**
     * The danger flash type
     * 
     * @var string $DANGER
     */
    public const DANGER = 'danger';
}
