<?php
/**
 * Webshop
 *
 */
$app->router->add("webshop/**", function () use ($app) {
    if (!$app->users->isAdmin()) {
        $app->redirect('');
    }
});

$app->router->add("webshop", function () use ($app) {
    $data = $app->shop->getStockData();
    $app->render("webshop/webshop", "Webshop", $data);
});


$app->router->add("webshop/edit/", function () use ($app) {
    $data = $app->shop->getStockData();
    $app->render("webshop/webshop", "Webshop", $data);
});

$app->router->add("webshop/edit/updateStock", function () use ($app) {
    $app->shop->updateData($app->request->getPost());
    $app->redirect('webshop');
});

$app->router->add("webshop/edit/delete", function () use ($app) {
    $app->shop->delete($app->request->getGet('delete'));
    $app->redirect('webshop');
});

$app->router->add("webshop/edit/addItem", function () use ($app) {
    $app->render("webshop/add", "Add");
});

$app->router->add("webshop/edit/addToStock", function () use ($app) {
    $app->shop->add($app->request->getPost());
    $app->redirect('webshop');
});

$app->router->add("webshop/cart", function () use ($app) {
    $data = $app->shop->getCart();
    $app->render("webshop/cart", "Cart", $data);
});

$app->router->add("webshop/checkout", function () use ($app) {
    $data = $app->shop->getOrderDetails();
    $app->render("webshop/checkout", "Checkout", $data);
});

$app->router->add("webshop/cart/addToCart", function () use ($app) {
    $app->shop->addToCart($app->request->getGet('add'));
    $app->redirect('webshop');
});

$app->router->add("webshop/cart/delete", function () use ($app) {
    $app->shop->deleteFromCart($app->request->getGet('delete'));
    $app->redirect('webshop/cart');
});
