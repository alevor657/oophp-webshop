<?php

/**
 * Profile
 *
 */
$app->router->add("profile", function () use ($app) {
    if (!$app->session->has('user')) {
        $app->redirect('');
    }

    $data = $app->users->getUserData($app->session->get('user'));
    $app->render("take1/profile", "Profile", $data);
});



$app->router->add("updateProfile", function () use ($app) {
    $app->users->updateProfile($_POST);
    $app->redirect('profile');
});



$app->router->add("dashboard", function () use ($app) {
    if (!($app->session->has('user') && $app->users->isAdmin())) {
        $app->redirect('');
    }

    $app->render("take1/dashboard", "Dashboard");
});

// updateAllUsers

$app->router->add("updateProfileDashboard", function () use ($app) {
    if (!($app->session->has('user') && $app->users->isAdmin())) {
        $app->redirect('');
    }

    $app->users->updateProfile($_POST);
    header("Location: " . $app->url->create('dashboard'));
});

$app->router->add("removeUser", function () use ($app) {
    if (!($app->session->has('user') && $app->users->isAdmin())) {
        $app->redirect('');
    }

    if (!empty($_GET['delete'])) {
        $app->users->removeUser($_GET['delete']);
    }
    $app->redirect('dashboard');
});
