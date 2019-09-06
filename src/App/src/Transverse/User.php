<?php
/**
 * PHP Kubectl Web console
 * @author Flávio Gomes da Silva Lisboa <flavio.lisboa@fgsl.eti.br>
 * @license https://www.gnu.org/licenses/lgpl-3.0.en.html
 */
declare(strict_types = 1);
namespace App\Transverse;

use Psr\Container\ContainerInterface;
use Zend\Session\SessionManager;

class User
{
    /** @var User */
    private static $instance = null;

    public static function start(ContainerInterface $container): void
    {
        $sessionManager = $container->get(SessionManager::class);        
        $sessionManager->getStorage()->user = self::getInstance($container);        
    }

    public static function getInstance(ContainerInterface $container = null):User
    {
        if (self::$instance == null) {
            self::$instance = new User($container);
        }
        return self::$instance;
    }
    
    public static function isAuthorized(string $username, string $password, ContainerInterface $container):bool
    {
        $credentials = include APP_ROOT . '/data/security/credentials.php';
        if (array_key_exists($username, $credentials['roles'])){
            return $credentials['roles'][$username] == $password;
        }
        return false;
    }

    private function __construct(ContainerInterface $container = null)
    {
    }
}