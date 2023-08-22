<?php

namespace App\OpenAPI;

use ApiPlatform\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\OpenApi\OpenApi;
use ApiPlatform\OpenApi\Model;

final class OpenApiFactory implements OpenApiFactoryInterface
{
    private $decorated;

    public function __construct(OpenApiFactoryInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function __invoke(array $context = []): OpenApi
    {
        $openApi = $this->decorated->__invoke($context);
        $paths = $openApi->getPaths()->getPaths();
        $filteredPaths = new Model\Paths();
        foreach ($paths as $path => $pathItem) {
            if ($path === '/api/foo/bundesland') {
                continue;
            }
            $filteredPaths->addPath($path, $pathItem);
        }
        return $openApi->withPaths($filteredPaths);
    }
}
