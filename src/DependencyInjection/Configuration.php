<?php

namespace Insidion\SwaggerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('insidion_swagger');

        $rootNode->children()
            // Caching
            ->booleanNode("cache")
                ->defaultTrue()
            ->end()

            ->arrayNode("swagger")
                ->children()
                    ->scalarNode('host')->defaultFalse()->end()
                    ->scalarNode('basePath')->defaultFalse()->end()

                    // Values for the swagger.json
                    ->arrayNode("produces")
                        ->info("This defines the produces MIME types in the swagger.json info object. See http://swagger.io/specification/#mimeTypes")
                        ->requiresAtLeastOneElement()
                        ->defaultValue(array('application/json'))
                        ->prototype('scalar')->end()
                    ->end()
                    ->arrayNode("consumes")
                        ->info("This defines the consumes MIME type in the swagger.json info object. See http://swagger.io/specification/#mimeTypes")
                        ->requiresAtLeastOneElement()
                        ->defaultValue(array('application/json'))
                        ->prototype('scalar')->end()
                    ->end()
                    ->arrayNode("schemes")
                        ->info("This defines the schemes in the swagger.json info object. Values MUST be from the list: \"http\", \"https\", \"ws\", \"wss\".")
                        ->requiresAtLeastOneElement()
                        ->defaultValue(array('http'))
                        ->prototype('scalar')->end()
                    ->end()

                    // Values for the info object in the swagger.json
                    ->arrayNode("info")
                        ->isRequired()
                        ->children()
                            ->scalarNode("title")->isRequired()->end()
                            ->scalarNode("description")->end()
                            ->scalarNode("termsOfService")->end()
                            ->scalarNode("version")->isRequired()->end()
                            ->arrayNode("contact")
                                ->children()
                                    ->scalarNode("name")->end()
                                    ->scalarNode("url")->end()
                                    ->scalarNode("email")->end()
                                ->end()
                            ->end()
                            ->arrayNode("license")
                                ->children()
                                    ->scalarNode("name")->isRequired()->end()
                                    ->scalarNode("url")->isRequired()->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
