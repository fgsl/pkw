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
            $module = $parsedBody['module'];
            $object = (bool) ($parsedBody['volumes-object'] ?? false);
            $output = KubectlProxy::getVolumes($module, $object)->__toString();            
        } catch (\Exception $e) {
            $output = $e->getMessage();
        }
        return new JsonResponse(['output' => $output]);
    }
}
