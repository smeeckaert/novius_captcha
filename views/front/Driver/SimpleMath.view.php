<?php

$config = \Config::load('novius_captcha::driver/simplemath');
$error = \Arr::get($params, 'error');
unset($params['error']);
?>
<div class="captcha simple-math <?= empty($error) ? : 'error' ?>">
    <label for=<?= \Arr::get($params, 'id') ?>><?= \Arr::get($config, 'question.label', '') ?>
        <?= \Arr::get($config, 'question.bold-equation', false) ? '<strong>' : '' ?>
        <?= implode(' ', array($one, $sign, $two)) ?>
        <?= \Arr::get($config, 'question.bold-equation', false) ? '</strong>' : '' ?>
    </label>

    <input type="text" name="<?= $name ?>" <?=
    $output = implode(' ', array_map(function ($v, $k) {
        return $k . '="' . $v . '"';
    }, $params, array_keys($params))); ?>>
    <?php

    if ($error) {
        ?>
        <small class="error"><?= $error ?></small>
    <?php
    }
    ?>
</div>