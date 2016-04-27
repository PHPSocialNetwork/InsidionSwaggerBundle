<?php

namespace Insidion\SwaggerBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class InsidionSwaggerExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        if ($config['cache'] === true) {
            $loader->load('cache.yml');
        }

        if (isset($config['swagger'])) {
            if ($config['swagger']['host'] === false) unset($config['swagger']['host']);
            if ($config['swagger']['basePath'] === false) unset($config['swagger']['basePath']);

            $container->setParameter("morlack.swagger.info", $config['swagger']);
        } else {
            $container->setParameter("morlack.swagger.info", array());
        }



        $loader->load('common.yml');
    }
}
