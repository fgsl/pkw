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
use Zend\Diactoros\Response\JsonResponse;

use function time;
use Fgsl\Kubectl\KubectlProxy;

class ResourceQuotaHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        try {
            $parsedBody = $request->getParsedBody();
            $namespace = $parsedBody['namespace'];
            $object = (bool) ($parsedBody['resourcequota-object'] ?? false);
            $output = KubectlProxy::getResourceQuota($namespace, $object)->__toString();            
        } catch (\Exception $e) {
            $output = $e->getMessage();
        }
        return new JsonResponse(['output' => $output]);
    }
}
