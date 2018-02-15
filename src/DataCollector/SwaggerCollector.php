<?php

/**
 *
 * This file is part of phpFastCache.
 *
 * @license MIT License (MIT)
 *
 * For full copyright and license information, please see the docs/CREDITS.txt file.
 *
 * @author Georges.L (Geolim4)  <contact@geolim4.com>
 * @author PastisD https://github.com/PastisD
 * @author Khoa Bui (khoaofgod)  <khoaofgod@gmail.com> http://www.phpfastcache.com
 *
 */

namespace Insidion\SwaggerBundle\DataCollector;

use Insidion\SwaggerBundle\Service\SwaggerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\RouterInterface;

class SwaggerCollector extends DataCollector
{
    /**
     * @var SwaggerBuilder $swaggerBuilder
     */
    private $swaggerBuilder;

    /**
     * @var RouterInterface $swaggerBuilder
     */
    private $router;

    /**
     * SwaggerCollector constructor.
     * @param SwaggerBuilder $builder
     * @param RouterInterface $Router
     */
    public function __construct(SwaggerBuilder $builder, RouterInterface $Router)
    {
        $this->swaggerBuilder = $builder;
        $this->router = $Router;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\HttpFoundation\Response $response
     * @param \Exception|null $exception
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $swaggerBuild = $this->swaggerBuilder->getSwaggerBuild();
        $paths = 0;

        try {
            $swagger_url = $this->router->generate('insidion_swagger_index');
        } catch (RouteNotFoundException $e) {
            $swagger_url = '';
        }

        if (!empty($swaggerBuild[ 'paths' ])) {
            foreach ($swaggerBuild[ 'paths' ] as $path) {
                foreach ($path as $method) {
                    $paths++;
                }
            }
        }
        $this->data = [
          'cache_enabled' => (bool)mt_rand(0, 1),
          'swagger_url' => $swagger_url,
          'stats' => [
            'routes' => $paths,
            'tags' => isset($swaggerBuild[ 'tags' ]) ? count($swaggerBuild[ 'tags' ]) : 0,
            'models' => isset($swaggerBuild[ 'definitions' ]) ? count($swaggerBuild[ 'definitions' ]) : 0,
            'schemes' => isset($swaggerBuild[ 'schemes' ]) ? count($swaggerBuild[ 'schemes' ]) : 0,
            'authorizations' => isset($swaggerBuild[ 'securityDefinitions' ]) ? count($swaggerBuild[ 'securityDefinitions' ]) : 0,
          ],
        ];
    }

    /**
     * @return mixed
     */
    public function getStats()
    {
        return $this->data[ 'stats' ];
    }

    /**
     * @return mixed
     */
    public function getCacheEnabled()
    {
        return $this->data[ 'cache_enabled' ];
    }

    /**
     * @return mixed
     */
    public function getSwaggerUrl()
    {
        return $this->data[ 'swagger_url' ];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'swagger';
    }

    public function reset()
    {

    }
}