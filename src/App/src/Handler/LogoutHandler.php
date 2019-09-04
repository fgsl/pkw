<?php
/**
 * PHP Kubectl Web console
 * @author Flávio Gomes da Silva Lisboa <flavio.lisboa@fgsl.eti.br>
 * @license https://www.gnu.org/licenses/lgpl-3.0.en.html
 */
declare(strict_types=1);

namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Session\SessionManager;
use Psr\Container\ContainerInterface;

class LogoutHandler implements RequestHandlerInterface
{
    /** @var string */
    private $containerName;

    /** @var Router\RouterInterface */
    private $router;

    /** @var null|TemplateRendererInterface */
    private $template;

    public function __construct(
        ContainerInterface $container,
        Router\RouterInterface $router
    ) {
        $this->container = $container;
        $this->router        = $router;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $sessionManager = $this->container->get(SessionManager::class);
        unset($sessionManager->getStorage()->user);
        $sessionManager->destroy();
        return new RedirectResponse($this->router->generateUri('home'));
    }
}