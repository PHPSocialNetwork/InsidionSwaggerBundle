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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

class SwaggerCollector extends DataCollector
{
    /**
     * SwaggerCollector constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\HttpFoundation\Response $response
     * @param \Exception|null $exception
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $this->data = [
          'cache_enabled' => (bool) mt_rand(0, 1),
          'stats' => [
            'routes' => mt_rand(2, 50),
            'tags' => mt_rand(2, 50),
            'models' => mt_rand(5, 50),
            'schemes' => mt_rand(1, 4),
            'authorizations' => 3,
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