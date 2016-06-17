<?php

namespace Novius\Captcha;

class Session
{
    /**
     * Session name
     *
     * @var string
     */
    protected $sessionName = null;

    /**
     * Forged instances
     *
     * @var array
     */
    protected static $instances = array();

    /**
     * Constructor
     *
     * @param $sessionName
     */
    public function __construct($sessionName)
    {
        $this->sessionName = $sessionName;
    }

    /**
     * Forges a session handler instance
     *
     * @param string $sessionName
     * @return static
     */
    public static function forge($sessionName = 'FRONTSESSID')
    {
        if (!isset(static::$instances[$sessionName])) {
            static::$instances[$sessionName] = new static($sessionName);
        }
        return static::$instances[$sessionName];
    }

    /**
     * Starts a session
     *
     * @param bool $id
     */
    public function create($id = null)
    {
        if (!session_id()) {
            if (!empty($id)) {
                session_id(strval($id));
            }
            // @fixme: The session id is too long or contains illegal characters, valid characters are a-z, A-Z, 0-9 and '-,'
            session_name($this->sessionName);
            @session_start();
        }
    }

    /**
     * Starts a session only if exists
     *
     * @return bool Returns true if a session already exists otherwise false
     */
    public function init()
    {
        if (!empty($_COOKIE[$this->sessionName])) {
            $this->create($_COOKIE[$this->sessionName]);
            return true;
        } elseif (!empty($_REQUEST[$this->sessionName])) {
            $this->create($_REQUEST[$this->sessionName]);
            return true;
        }
        return false;
    }

    /**
     * Sets a key/value in session
     *
     * @param $name
     * @param $value
     */
    public function set($name, $value)
    {
        $this->create();
        \Arr::set($_SESSION, $name, $value);
    }

    /**
     * Appends a value to a key in session
     *
     * @param string $key
     * @param mixed $value
     */
    public function append($key, $value, $default = null)
    {
        if (is_array($value) && is_null($default)) {
            $default = array();
        }

        // Gets the existing value
        $previous_value = $this->get($key, $default);

        // Appends the new value to the existing value
        if (is_array($previous_value)) {
            $previous_value[] = $value;
        } elseif (is_array($value)) {
            $previous_value = $value;
        } else {
            $previous_value .= $value;
        }

        // Saves the new value
        $this->set($key, $previous_value);
    }

    /**
     * Deletes a key in session
     *
     * @param string $name
     */
    public function delete($name)
    {
        if ($this->init()) {
            \Arr::delete($_SESSION, $name);
        }
    }

    /**
     * Gets a key value from session
     *
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    public function get($name, $default = null)
    {
        if (!$this->init()) {
            return $default;
        }
        $value = \Arr::get($_SESSION, $name);
        return !is_null($value) ? $value : $default;
    }

    /**
     * Gets the session name
     *
     * @return string
     */
    public function getSessionName()
    {
        return $this->sessionName;
    }
}