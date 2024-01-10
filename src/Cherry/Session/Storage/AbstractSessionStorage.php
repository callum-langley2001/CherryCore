<?php

declare(strict_types=1);

namespace Cherry\Session\Storage;

use Cherry\Session\Storage\SessionStorageInterface;

/**
 * Abstract Class AbstractSessionStorage
 * 
 * @package Cherry
 * @subpackage Session\Storage
 * @author Callum Langley <callumlangley9@gmail.com>
 * @license MIT
 * @version 1.0.0
 * @since 1.0.0
 * @abstract
 * @implements SessionStorageInterface
 * @see SessionStorageInterface
 */
abstract class AbstractSessionStorage implements SessionStorageInterface
{
    /**
     * Session options.
     * 
     * @var array $options The options to set on the session
     */
    protected array $options = [];

    /**
     * Constructs a new instance of the class.
     *
     * @param array $options (Optional) An array of options for the constructor.
     * @return void
     */
    public function __construct(array $options = [])
    {
        $this->options = $options;

        $this->iniSet();

        if ($this->isSessionStarted()) {
            session_unset();
            session_destroy();
        }

        $this->start();
    }

    /**
     * Sets the name of the session.
     *
     * @param string $name The name of the session.
     * @return void
     */
    public function setSessionName(string $name): void
    {
        session_name($name);
    }

    /**
     * Retrieves the session name.
     *
     * @return string The name of the session.
     */
    public function getSessionName(): string
    {
        return session_name();
    }

    /**
     * Sets the session ID for the PHP function.
     *
     * @param string $id The session ID to set.
     * @return void
     */
    public function setSessionId(string $id): void
    {
        session_id($id);
    }

    /**
     * Retrieves the session ID as a string.
     *
     * @return string The session ID.
     */
    public function getSessionId(): string
    {
        return (string)session_id();
    }

    /**
     * Sets the configuration options for the PHP session.
     * 
     * @return void
     */
    public function iniSet(): void
    {
        ini_set('session.gc_maxlifetime', $this->options['gc_maxlifetime']);
        ini_set('session.gc_divisor', $this->options['gc_divisor']);
        ini_set('session.gc_probability', $this->options['gc_probability']);
        ini_set('session.cookie_lifetime', $this->options['cookie_lifetime']);
        ini_set('session.use_cookies', $this->options['use_cookies']);
    }

    /**
     * Checks if a session has been started.
     *
     * @return bool Returns true if a session has been started, false otherwise.
     */
    public function isSessionStarted(): bool
    {
        return php_sapi_name() !== 'cli'
            ? $this->getSessionId() !== ''
            : false;
    }

    /**
     * Starts a session.
     *
     * @return void
     */
    public function startSession(): void
    {
        if (session_status() == PHP_SESSION_NONE) session_start();
    }

    /**
     * Starts the session.
     *
     * @return void
     */
    public function start()
    {
        $this->setSessionName($this->options['session_name']);
        $domain = (
            isset($this->options['domain'])
            ? $this->options['domain']
            : isset($_SERVER['SERVER_NAME'])
        );
        $secure = (
            isset($this->options['secure'])
            ? $this->options['secure']
            : isset($_SERVER['HTTPS'])
        );

        session_set_cookie_params(
            $this->options['lifetime'],
            $domain,
            $this->options['path'],
            $secure,
            $this->options['httponly']
        );

        $this->startSession();
    }
}
