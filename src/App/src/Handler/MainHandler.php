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
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Router;
use Zend\Expressive\Template\TemplateRendererInterface;
use Psr\Container\ContainerInterface;
use App\Transverse\User;
use Zend\Session\SessionManager;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Router\RouterInterface;

class MainHandler implements RequestHandlerInterface
{
    /** @var ContainerInterface */
    private $container;

    /** @var Router\RouterInterface */
    private $router;

    /** @var null|TemplateRendererInterface */
    private $template;

    public function __construct(
        ContainerInterface $container,
        RouterInterface $router,
        TemplateRendererInterface $template = null
    ) {
        $this->container     = $container;
        $this->router        = $router;
        $this->template      = $template;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {   
        $data = [];
        $sessionManager = $this->container->get(SessionManager::class);
        if (!isset($sessionManager->getStorage()->user)){
            return new RedirectResponse($this->router->generateUri('home'));
        }
        $data['user'] = $sessionManager->getStorage()->user;
        return new HtmlResponse($this->template->render('app::main', $data));
    }
}
