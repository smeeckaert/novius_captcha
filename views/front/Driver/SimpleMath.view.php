<?php

$config = \Config::load('novius_captcha::driver/simplemath');

?>
<div class="captcha simple-math">
    <label for=<?= \Arr::get($params, 'id') ?>><?= \Arr::get($config, 'question.label', '') ?>
        <?= \Arr::get($config, 'question.bold-equation', false) ? '<strong>' : '' ?>
        <?= implode(' ', array($one, $sign, $two)) ?>
        <?= \Arr::get($config, 'question.bold-equation', false) ? '</strong>' : '' ?>
    </label>

    <input type="text" name="<?= $name ?>" <?=
    $output = implode(' ', array_map(function ($v, $k) {
        return $k . '="' . $v . '"';
    }, $params, array_keys($params))); ?>>
</div>