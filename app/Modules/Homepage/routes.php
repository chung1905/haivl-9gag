<?php

$prefix = "/";  // URL prefix

$module = basename(__DIR__);
$namespace = "App\Modules\\{$module}\Controllers";
$middleware = "web";

Route::group(
    ["prefix" => $prefix, "module" => $module, "namespace" => $namespace, "middleware" => $middleware],
    function() use($module) {
        Route::get('/', [
            "uses" => "{$module}Controller@index"
        ]);
        Route::get("/tag/{tag}","{$module}Controller@index");
        Route::get("/loadpage","{$module}Controller@loadPage");
    }
);