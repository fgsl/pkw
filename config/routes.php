<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Zend\Expressive\Application;
use Zend\Expressive\MiddlewareFactory;

/**
 * Setup routes with a single request method:
 *
 * $app->get('/', App\Handler\HomePageHandler::class, 'home');
 * $app->post('/album', App\Handler\AlbumCreateHandler::class, 'album.create');
 * $app->put('/album/:id', App\Handler\AlbumUpdateHandler::class, 'album.put');
 * $app->patch('/album/:id', App\Handler\AlbumUpdateHandler::class, 'album.patch');
 * $app->delete('/album/:id', App\Handler\AlbumDeleteHandler::class, 'album.delete');
 *
 * Or with multiple request methods:
 *
 * $app->route('/contact', App\Handler\ContactHandler::class, ['GET', 'POST', ...], 'contact');
 *
 * Or handling all request methods:
 *
 * $app->route('/contact', App\Handler\ContactHandler::class)->setName('contact');
 *
 * or:
 *
 * $app->route(
 *     '/contact',
 *     App\Handler\ContactHandler::class,
 *     Zend\Expressive\Router\Route::HTTP_METHOD_ANY,
 *     'contact'
 * );
 */
return function (Application $app, MiddlewareFactory $factory, ContainerInterface $container) : void {
    $app->get('/', App\Handler\HomePageHandler::class, 'home');
    $app->post('/login', App\Handler\LoginHandler::class, 'app.login');
    $app->get('/logout', App\Handler\LogoutHandler::class, 'app.logout');
    $app->get('/main', App\Handler\MainHandler::class, 'app.main');
    $app->get('/api/ping', App\Handler\PingHandler::class, 'api.ping');
    $app->post('/namespace', App\Handler\NamespaceHandler::class, 'app.namespace');
    $app->post('/resourcequota', App\Handler\ResourceQuotaHandler::class, 'app.resourcequota');
    $app->post('/pods', App\Handler\PodsHandler::class, 'app.pods');
    $app->post('/pod', App\Handler\PodsHandler::class, 'app.pod');
};
