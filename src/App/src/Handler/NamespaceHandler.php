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

class NamespaceHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        try {
            $parsedBody = $request->getParsedBody();
            $namespace = $parsedBody['namespace'];
            $object = (bool) ($parsedBody['namespace-object'] ?? false);
            $annotations = (bool) ($parsedBody['namespace-annotations'] ?? false);
            $labels = (bool) ($parsedBody['namespace-labels'] ?? false);
            if ($annotations){
                $output = KubectlProxy::getNamespace($namespace, true)->getAnnotations();
                goto response;
            }
            if ($labels){
                $output = KubectlProxy::getNamespace($namespace, true)->getLabels();
                goto response;
            }
            $output = KubectlProxy::getNamespace($namespace, $object)->__toString();            
        } catch (\Exception $e) {
            $output = $e->getMessage();
        }
response:        
        return new JsonResponse(['output' => $output]);
    }
}
