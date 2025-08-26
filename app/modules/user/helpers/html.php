<?php
// app/helpers/html.php

function h($v, string $default = ''): string {
    $val = ($v === null || $v === '') ? $default : $v;
    return htmlspecialchars((string)$val, ENT_QUOTES, 'UTF-8');
}

function selected_attr($actual, $valor): string {
    return ((string)$actual === (string)$valor) ? 'selected' : '';
}
