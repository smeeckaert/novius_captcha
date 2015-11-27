<?php

namespace Novius\Captcha;


interface Driver
{
    public function init($field);

    public function check($storedValue, $submittedValue);

    public function display($params);

}