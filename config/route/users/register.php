<?php
/**
 * Register
 *
 */
$app->router->add("register", function () use ($app) {
    $app->users->register($_POST);
});

$app->router->add("wrongFormData", function () use ($app) {
    $app->render("users/wrongFormData", "Something went wrong!");
});
