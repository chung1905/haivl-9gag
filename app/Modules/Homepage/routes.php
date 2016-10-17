<?php

$prefix = "hello";  // URL prefix

$module = basename(__DIR__);
$namespace = "App\Modules\\{$module}\Controllers";
$middleware = "web";

Route::group(
    ["prefix" => $prefix, "module" => $module, "namespace" => $namespace, "middleware" => $middleware],
    function() use($module) {
        Route::get('/',[
            # middle here
            "as" => "{$module}.index",
            "uses" => "{$module}Controller@index"
        ]);
        Route::post('/submit', [
            "uses" => "{$module}Controller@submit"
        ]);
    });