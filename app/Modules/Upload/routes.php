<?php

$prefix = "upload";  // URL prefix

$module = basename(__DIR__);
$namespace = "App\Modules\\{$module}\Controllers";
$middleware = ["web", "auth" ];

Route::group(
    ["prefix" => $prefix, "module" => $module, "namespace" => $namespace, "middleware" => $middleware],
    function() use($module) {
        Route::match(['get', 'post'], '/',[
            # middle here
            "as" => "{$module}.index",
            "uses" => "{$module}Controller@index"
        ]);
    });