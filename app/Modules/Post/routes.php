<?php

$prefix = "post";  // URL prefix

$module = basename(__DIR__);
$namespace = "App\Modules\\{$module}\Controllers";
$middleware = ["web"];

Route::group(
    ["prefix" => $prefix, "module" => $module, "namespace" => $namespace, "middleware" => $middleware],
    function() use($module) {
        Route::get('/{id}',"{$module}Controller@index");
    });