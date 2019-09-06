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
use App\Transverse\User;
use Psr\Container\ContainerInterface;

class LoginHandler implements RequestHandlerInterface
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
        $this->container     = $container;
        $this->router        = $router;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $parsedBody = $request->getParsedBody();
        $username = $parsedBody['username'] ?? null;
        $password = $parsedBody['password'] ?? null;
        if (!is_null($username) && !is_null($password) && User::isAuthorized($username,$password, $this->container)){
            User::start($this->container);
            return new RedirectResponse($this->router->generateUri('app.main'));
        }
        return new RedirectResponse($this->router->generateUri('home'));
    }
}