<?php

declare(strict_types=1);

namespace Cherry\Traits;

use Cherry\Base\Exception\BaseLogicException;
use Cherry\GlobalManager\GlobalManager;
use Cherry\Session\SessionManager;
use Cherry\Session\Session;

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
    /**
     * Initializes the session.
     *
     * @param bool $useSessionGlobal (Optional) Determines if the session should be set as a global variable.
     * @throws BaseLogicException If the session settings inside the session.yaml file are incorrect.
     * @return Session|null The initialized session object.
     */
    public static function sessionInit(bool $useSessionGlobal = false): ?Session
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
