<?php

use App\Modules\Config\Models\Config;

$prefix = "/";  // URL prefix

$module = basename(__DIR__);
$namespace = "App\Modules\\{$module}\Controllers";
$middleware = "web";

$category = Config::getConfigData()['category'];

Route::group(
    ["prefix" => $prefix, "module" => $module, "namespace" => $namespace, "middleware" => $middleware],
    function() use($module, $category) {
        Route::get('/', [
            # middle here
            # "as" => "{$module}.index",
            "uses" => "{$module}Controller@index"
        ]);
        foreach ($category as $c) {
            Route::get($c, [
                "uses" => "{$module}Controller@index"
            ]);
        }
    }
);