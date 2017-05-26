<?php
$app->router->addInternal("404", function () use ($app) {
    $app->view->add("take1/header", ["title" => "Home"]);
    $app->view->add("navbar1/navbar");
    $app->view->add("take1/login_modal");
    $app->view->add("take1/404");
    $app->view->add("take1/footer");

    $app->response->setBody([$app->view, "render"])->send(404);
    // $app->response->setBody([$app->view, "render"])->send();
});
