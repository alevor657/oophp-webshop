<?php
$app->router->add("login", function () use ($app) {
    $app->users->login($_POST);
});

$app->router->add("logout", function () use ($app) {
    $app->users->logout();
});
