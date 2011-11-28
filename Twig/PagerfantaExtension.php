<?php

/*
 * This file is part of the Pagerfanta package.
 *
 * (c) Pablo Díez <pablodip@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WhiteOctober\PagerfantaBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Util\PropertyPath;
use Pagerfanta\PagerfantaInterface;

/**
 * PagerfantaExtension.
 *
 * @author Pablo Díez <pablodip@gmail.com>
 */
class PagerfantaExtension extends \Twig_Extension
{
    private $container;

    /**
     * Constructor.
     *
     * @param ContainerInterface $container A container.
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            'pagerfanta' => new \Twig_Function_Method($this, 'renderPagerfanta', array('is_safe' => array('html'))),
        );
    }

    /**
     * Renders a pagerfanta.
     *
     * @param PagerfantaInterface $pagerfanta The pagerfanta.
     * @param string              $viewName   The view name.
     * @param array               $options    An array of options (optional).
     *
     * @return string The pagerfanta rendered.
     */
    public function renderPagerfanta(PagerfantaInterface $pagerfanta, $viewName = 'default', array $options = array())
    {
        $options = array_replace(array(
            'routeName'     => null,
            'routeParams'   => array(),
            'pageParameter' => 'page',
        ), $options);

        $router = $this->container->get('router');

        if (null === $options['routeName']) {
            $request = $this->container->get('request');

            $options['routeName'] = $request->attributes->get('_route');
            if ('_internal' === $options['routeName']) {
                throw new \Exception('PagerfantaBundle can not guess the route when used in a subrequest');
            }
            $options['routeParams'] = $request->query->all();
            foreach ($router->getRouteCollection()->get($options['routeName'])->compile()->getVariables() as $variable) {
                $options['routeParams'][$variable] = $request->attributes->get($variable);
            }
        }

        $routeName = $options['routeName'];
        $routeParams = $options['routeParams'];
        $pagePropertyPath = new PropertyPath($options['pageParameter']);
        $routeGenerator = function($page) use($router, $routeName, $routeParams, $pagePropertyPath) {
            $pagePropertyPath->setValue($routeParams, $page);
            return $router->generate($routeName, $routeParams);
        };

        return $this->container->get('white_october_pagerfanta.view_factory')->get($viewName)->render($pagerfanta, $routeGenerator, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'pagerfanta';
    }
}
