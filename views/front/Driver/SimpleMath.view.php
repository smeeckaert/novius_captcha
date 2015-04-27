<div class="captcha simple-math">
    <span>
        <?= implode(' ', array($one, $sign, $two)) ?>
    </span>
    <input type="text" name="<?= $name ?>" <?=
    $output = implode(' ', array_map(function ($v, $k) {
        return $k . '="' . $v . '"';
    }, $params, array_keys($params))); ?>>
</div>