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
use Fgsl\Kubectl\KubernetesPods;

class PodsHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        try {
            if (isset($_FILES['yaml'])){
                $output = KubernetesPods::create(file_get_contents($_FILES['yaml']['tmp_name']));
                goto response;
            }            
            $parsedBody = $request->getParsedBody();
            $namespace = $parsedBody['namespace'];
            if (isset($parsedBody['module'])){
                $module = $parsedBody['module'];
                $output = KubernetesPods::delete($namespace, $module);
                goto response;
            }            
            $object = (bool) ($parsedBody['pods-object'] ?? false);
            $showLabels = (bool) ($parsedBody['pods-labels'] ?? false);
            $output = KubectlProxy::getPods($namespace, $object, $showLabels)->__toString();            
        } catch (\Exception $e) {
            $output = $e->getMessage();
        }
response:        
        return new JsonResponse(['output' => $output]);
    }
}
