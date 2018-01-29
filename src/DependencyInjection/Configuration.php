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
            ->booleanNode("cache")
                ->defaultTrue()
            ->end()
            ->arrayNode("swagger")
                ->children()
                    ->scalarNode('host')->defaultFalse()->end()
                    ->scalarNode('basePath')->defaultFalse()->end()
                    ->arrayNode("produces")
                        ->info("This defines the produces MIME types in the swagger.json info object. See http://swagger.io/specification/#mimeTypes")
                        ->requiresAtLeastOneElement()
                        ->defaultValue(['application/json'])
                        ->prototype('scalar')->end()
                    ->end()
                    ->arrayNode("consumes")
                        ->info("This defines the consumes MIME type in the swagger.json info object. See http://swagger.io/specification/#mimeTypes")
                        ->requiresAtLeastOneElement()
                        ->defaultValue(['application/json'])
                        ->prototype('scalar')->end()
                    ->end()
                    ->arrayNode("schemes")
                        ->info("This defines the schemes in the swagger.json info object. Values MUST be from the list: \"http\", \"https\", \"ws\", \"wss\".")
                        ->requiresAtLeastOneElement()
                        ->defaultValue(['http'])
                        ->validate()
                        ->always(function ($values) {
                          foreach ((array) $values as $val) {
                              if (!in_array($val, ["http", "https", "ws", "wss"])) {
                                  throw new \Symfony\Component\Config\Definition\Exception\InvalidTypeException("Invalid value ".$val);
                              }
                          }
                          return (array) $values;
                        })
                        ->end()
                        ->prototype('scalar')->end()
                    ->end()
                    ->arrayNode('securityDefinitions')
                        ->info('Lorem ipsum')
                        ->defaultValue([])
                        ->prototype('array')
                            //->ignoreExtraKeys()
                            ->children()
                                ->enumNode('type')->isRequired()->values(['http', 'apiKey', 'oauth2', 'openIdConnect'])->end()
                                ->scalarNode('in')->end()
                                ->scalarNode('name')->end()
                                ->scalarNode('scheme')->end()
                                ->scalarNode('openIdConnectUrl')->end()
                                ->arrayNode('flow')->ignoreExtraKeys(false)->end()
                            ->end()
                        ->end()
                    ->end()
                    ->arrayNode('tags')
                        ->info('Lorem ipsum')
                        ->defaultValue([])
                        ->prototype('array')
                            ->children()
                                ->scalarNode('name')->isRequired()->cannotBeEmpty()->end()
                                ->scalarNode('description')->defaultValue('')->end()
                                ->arrayNode('externalDocs')
                                    ->children()
                                        ->scalarNode('description')->isRequired()->cannotBeEmpty()->end()
                                        ->scalarNode('url')->defaultValue('')->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                    ->arrayNode("info")
                        ->isRequired()
                        ->children()
                            ->scalarNode("title")->isRequired()->end()
                            ->scalarNode("description")->defaultValue('')->end()
                            ->scalarNode("termsOfService")->defaultValue('')->end()
                            ->scalarNode("version")->defaultValue('')->isRequired()->end()
                            ->arrayNode("contact")
                                ->children()
                                    ->scalarNode("name")->isRequired()->end()
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
                    ->arrayNode('externalDocs')
                        ->children()
                            ->scalarNode('description')->isRequired()->cannotBeEmpty()->end()
                            ->scalarNode('url')->defaultValue('')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}