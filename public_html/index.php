<?php

    require_once __DIR__ . '/../vendor/autoload.php';

    use app\Router;
    use app\controllers\RankController;

    $router = new Router;
    $product_controller = new RankController;

    session_start();

    $router->get('/', [$product_controller, 'index']);
    $router->get('/ranks', [$product_controller, 'index']);
    $router->get('/ranks/view', [$product_controller, 'viewDetail']);

    $router->get('/admin', [$product_controller, 'admin']);
    $router->get('/admin/ranks', [$product_controller, 'admin']);
    $router->get('/admin/ranks/view', [$product_controller, 'viewDetailUpdate']);
    $router->post('/admin/ranks/view', [$product_controller, 'viewDetailUpdate']);

    $router->get('/ranks/create', [$product_controller, 'create']);
    $router->post('/ranks/create', [$product_controller, 'create']);
    $router->get('/ranks/update', [$product_controller, 'update']);
    $router->post('/ranks/update', [$product_controller, 'update']);
    $router->post('/ranks/delete', [$product_controller, 'delete']);
    $router->post('/ranks/updateOrder/', [$product_controller, 'updateOrder']);

    $router->get('/admin/login', [$product_controller, 'login']);
    $router->post('/admin/login', [$product_controller, 'login']);
    $router->get('/logout', [$product_controller, 'logout']);

    $router->get('/site/update', [$product_controller, 'site_update']);
    $router->post('/site/update', [$product_controller, 'site_update']);

    $router->resolve();