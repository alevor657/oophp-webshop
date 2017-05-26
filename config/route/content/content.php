<?php

/**
 * Content
 *
 */
$app->router->add("content", function () use ($app) {

    $app->view->add("take1/header", ["title" => "Content"]);
    $app->view->add("navbar1/navbar");
    $app->view->add("take1/login_modal");
    if ($app->request->getGet('route')) {
        $app->view->add("pages/page_route");
    } else {
        $app->view->add("pages/pages");
    }
    $app->view->add("take1/footer");

    $app->response->setBody([$app->view, "render"])->send();
});



/**
 *
 *
 */
$app->router->add("content/edit/**", function () use ($app) {
    if (!$app->users->isAdmin()) {
        $app->response->redirect($app->url->create(''));
    }
});



$app->router->add("content/edit/", function () use ($app) {
    $app->view->add("take1/header", ["title" => "Content"]);
    $app->view->add("navbar1/navbar");
    $app->view->add("take1/login_modal");
    $app->view->add("pages/edit");
    $app->view->add("take1/footer");

    $app->response->setBody([$app->view, "render"])->send();
});



/**
 *
 *
 */
$app->router->add("content/edit/updateContent", function () use ($app) {
    $app->content->updateContent($app->request->getPost());
    $app->response->redirect($app->url->create('content'));
});



/**
 *
 *
 */
$app->router->add("content/edit/addContent", function () use ($app) {
    $app->view->add("take1/header", ["title" => "Content"]);
    $app->view->add("navbar1/navbar");
    $app->view->add("take1/login_modal");
    $app->view->add("pages/add");
    $app->view->add("take1/footer");

    $app->response->setBody([$app->view, "render"])->send();
});




/**
 *
 *
 */
$app->router->add("content/edit/createContent", function () use ($app) {
    $app->content->add($app->request->getPost());
    $app->response->redirect($app->url->create('content'));
});



/**
 *
 *
 */
$app->router->add("content/edit/delete", function () use ($app) {
    $id = $app->request->getGet('delete');
    $app->content->delete($id);
    $app->response->redirect($app->url->create('content'));
});



/**
 *
 *
 */
$app->router->add("content/edit/purge", function () use ($app) {
    $id = $app->request->getGet('purge');
    $app->content->purge($id);
    $app->response->redirect($app->url->create('content'));
});
