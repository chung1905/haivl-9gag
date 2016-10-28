<?php

use App\Modules\Homepage\Models\Homepage;

$prefix = "/";  // URL prefix

$module = basename(__DIR__);
$namespace = "App\Modules\\{$module}\Controllers";
$middleware = "web";

$navbar = array_merge(['hot', 'trending', 'fresh'], Homepage::getConfigData()['tags']);

Route::group(
    ["prefix" => $prefix, "module" => $module, "namespace" => $namespace, "middleware" => $middleware],
    function() use($module, $navbar) {
        Route::get('/', [
            # middle here
            # "as" => "{$module}.index",
            "uses" => "{$module}Controller@index"
        ]);
        foreach ($navbar as $n) {
            Route::get($n, [
                "uses" => "{$module}Controller@index"
            ]);
        }
    }
);