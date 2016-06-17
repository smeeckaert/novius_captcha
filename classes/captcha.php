<?php

namespace Novius\Captcha;

class Captcha
{
    /** @var  Driver */
    private $driver;
    protected $session;

    private function __construct($driverClass)
    {
        $this->session = Session::forge();
        $this->driver = new $driverClass();
    }

    public function init($fieldName)
    {
        $this->storeAnswer($fieldName, $this->driver->init($fieldName));
    }

    public function display($params = array())
    {
        return $this->driver->display($params);
    }

    private function storeAnswer($field, $value)
    {
        $this->session->set($this->getSessionVar($field), $value);
    }

    public function check($fieldName, $value)
    {
        $stored = $this->session->get($this->getSessionVar($fieldName));
        if (empty($stored)) {
            return false;
        }
        $value = $this->driver->check($stored, $value);
        // Reset the captcha
        $this->init($fieldName);
        return $value;
    }

    private function  getSessionVar($field)
    {
        return "captcha_$field";
    }


    public static function forge($params = array())
    {
        $driver = \Arr::get($params, 'driver');
        if (empty($driver)) {
            $config = \Config::load('novius_captcha::captcha');
            $driver = \Arr::get($config, 'driver.default');
        }
        return new static($driver);
    }

}