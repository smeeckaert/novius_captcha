<?php

namespace Novius\Captcha;

class Driver_SimpleMath
{
    private $one, $sign, $two;
    private $name;

    public function init($fieldName)
    {
        $this->one  = rand(1, 40);
        $this->sign = rand(0, 1) ? '+' : '-';
        $this->two  = rand(1, 12);
        $this->name = $fieldName;

        // This is a test for dummies, we don't want negative value
        if ($this->one < $this->two) {
            $btwo      = $this->two;
            $this->two = $this->one;
            $this->one = $btwo;
        }
        return (int)eval('return (' . $this->one . $this->sign . $this->two . ');');
    }

    public function display($params = array())
    {
        return \View::forge('novius_captcha::front/Driver/SimpleMath', array(
            'one'    => $this->one,
            'two'    => $this->two,
            'sign'   => $this->sign,
            'name'   => $this->name,
            'params' => $params
        ));
    }

    public function check($storedValue, $value)
    {
        return $storedValue == $value;
    }
}