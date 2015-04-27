# Captcha

Captcha is a bunch of tools meant to use easily captchas in Novius OS.


## Captcha

The class Captcha will do most of the most, it will invoke drivers for operations and will store useful infos in sessions.

The class Captcha expose these methods.

### forge($params)

Intantiate a Captcha object, if not given in params, the 'driver' will be the default driver given in the configuration.

### init($fieldname)

This method call the init() method of the driver and store its return in session.

### display($params)

Calls the driver display() methods.

$params are mostly here to be used as view parameters.

### check($fieldname, $value)

Check the previously stored value for $fieldname against $value.

If no previous value was stored, it returns false.

## Examples

```php

$captcha = \Novius\Captcha\Captcha::forge();
$captcha->init('captcha');

echo $captcha->display(); // Will display the captcha

// ... Later ...

$captcha->check('captcha', $_POST['captcha']); // True / false
```

Example with an other driver
```php
$captcha = \Novius\Captcha\Captcha::forge(array('driver' => '\Local\Test_Driver');

```

## Configuration

### captcha

#### driver

##### default

The default driver used if it's not given in the forge method

## Bundled Drivers

### SimpleMath

SimpleMath will ask a simple math question to the user.

## Writing a new driver

You just have to extend from the \Novius\Captcha\Driver interface and implement the public methods and then give the class name in the forge method.

## License

‘Captcha’ is licensed under [GNU Affero General Public License v3](http://www.gnu.org/licenses/agpl-3.0.html) or (at your option) any later version.
