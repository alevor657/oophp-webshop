<?php



/**
 * Home
 *
 */
$app->router->add("", function () use ($app) {
    $data = $app->shop->getStockData();
    $app->render("webshop/products", "Products", $data);
});



/**
 * About
 *
 */
$app->router->add("about", function () use ($app) {
    $data = $app->content->getDataByTitle('about');
    $app->render("take1/about", "About", $data);
});



/**
 * Details
 */
$app->router->add("status", function () use ($app) {
    $data = [
        "Server" => php_uname(),
        "PHP version" => phpversion(),
        "Included files" => count(get_included_files()),
        "Memory used" => memory_get_peak_usage(true),
        "Execution time" => microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'],
    ];

    $app->response->sendJson($data);
});
