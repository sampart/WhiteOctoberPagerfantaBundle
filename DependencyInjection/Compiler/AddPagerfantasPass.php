<?php

/*
 * This file is part of the Pagerfanta package.
 *
 * (c) Pablo Díez <pablodip@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WhiteOctober\PagerfantaBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * AddPagerfantasPass.
 *
 * @author Pablo Díez <pablodip@gmail.com>
 */
class AddPagerfantasPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('white_october_pagerfanta.view_factory')) {
            return;
        }

        $views = array();
        foreach ($container->findTaggedServiceIds('pagerfanta.view') as $serviceId => $arguments) {
            $alias = isset($arguments[0]['alias']) ? $arguments[0]['alias'] : $serviceId;

            $views[$alias] = new Reference($serviceId);
        }

        $container->getDefinition('white_october_pagerfanta.view_factory')->addMethodCall('add', array($views));
    }
}
