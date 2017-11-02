<?php

/*
 * This file is part of the Pagerfanta package.
 *
 * (c) Pablo Díez <pablodip@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WhiteOctober\PagerfantaBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * WhiteOctoberPagerfantaExtension.
 *
 * @author Pablo Díez <pablodip@gmail.com>
 */
class WhiteOctoberPagerfantaExtension extends Extension
{
    /**
     * Responds to the "white_october_pagerfanta" configuration parameter.
     *
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $processor = new Processor();

        $config = $processor->processConfiguration($configuration, $configs);
        $container->setParameter('white_october_pagerfanta.default_view', $config['default_view']);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('pagerfanta.xml');

        if ($config['exceptions_strategy']['out_of_range_page'] == Configuration::EXCEPTION_STRATEGY_TO_HTTP_NOT_FOUND) {
            $convertListener = $container->getDefinition('pagerfanta.convert_not_valid_max_per_page_to_not_found_listener');
            $convertListener->addTag('kernel.event_subscriber');
        }

        if ($config['exceptions_strategy']['not_valid_current_page'] == Configuration::EXCEPTION_STRATEGY_TO_HTTP_NOT_FOUND) {
            $convertListener = $container->getDefinition('pagerfanta.convert_not_valid_current_page_to_not_found_listener');
            $convertListener->addTag('kernel.event_subscriber');
        }

        // BC layer to inject the 'request' service when RequestStack is unavailable
        if (!class_exists('Symfony\\Component\\HttpFoundation\\RequestStack')) {
            $container
                ->getDefinition('twig.extension.pagerfanta')
                ->addMethodCall('setRequest', array(
                    new Reference('request', ContainerInterface::NULL_ON_INVALID_REFERENCE, false),
                ))
            ;
        }
    }
}
