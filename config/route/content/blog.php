<?php



/**
 * Blog
 *
 */
$app->router->add("blog", function () use ($app) {

    $app->view->add("take1/header", ["title" => "Content"]);
    $app->view->add("navbar1/navbar");
    $app->view->add("take1/login_modal");
    $app->view->add("blog/blog");
    $app->view->add("take1/footer");

    $app->response->setBody([$app->view, "render"])->send();
});



$app->router->add("blog/{route}", function ($route) use ($app) {
    $app->view->add("take1/header", ["title" => "Content"]);
    $app->view->add("navbar1/navbar");
    $app->view->add("take1/login_modal");
    $app->view->add("blog/blog", ["route" => $route]);
    $app->view->add("block/block", ["data" => $app->content->getBlockData()]);
    $app->view->add("take1/footer");

    $app->response->setBody([$app->view, "render"])->send();
});
