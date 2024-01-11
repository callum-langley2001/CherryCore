<?php

declare(strict_types=1);

namespace Cherry\Traits;

use Cherry\Base\Exception\BaseLogicException;
use Cherry\GlobalManager\GlobalManager;
use Cherry\Session\SessionManager;

/**
 * Trait SystemTrait
 * 
 * @package Cherry
 * @subpackage Traits
 * @author Callum Langley <callumlangley9@gmail.com>
 * @license MIT
 * @version 1.0.0
 * @since 1.0.0
 */
trait SystemTrait
{
    public static function sessionInit(bool $useSessionGlobal = false)
    {
        $session = SessionManager::init();

        if (!$session) {
            throw new BaseLogicException('Please check your session settings inside your session.yaml file.');
        } elseif ($useSessionGlobal === true) {
            GlobalManager::set('global_session', $session);
        } else {
            return $session;
        }
    }
}
