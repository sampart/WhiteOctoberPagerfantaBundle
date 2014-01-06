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
use Symfony\Component\PropertyAccess\PropertyPath;
use Symfony\Component\PropertyAccess\PropertyAccess;
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
            'pagerfanta_page_url' => new \Twig_Function_Method($this, 'getPageUrl')
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
    public function renderPagerfanta(PagerfantaInterface $pagerfanta, $viewName = null, array $options = array())
    {
        if (null === $viewName) {
            $viewName = $this->container->getParameter('white_october_pagerfanta.default_view');
        }

        $routeGenerator = $this->createRouteGenerator($options);

        return $this->container->get('white_october_pagerfanta.view_factory')->get($viewName)->render($pagerfanta, $routeGenerator, $options);
    }

    /**
     * Generates the url for a given page in a pagerfanta instance.
     *
     * @param \Pagerfanta\PagerfantaInterface $pagerfanta
     * @param $page
     * @param array $options
     *
     * @return string The url of the given page
     *
     * @throws \InvalidArgumentException
     */
    public function getPageUrl(PagerfantaInterface $pagerfanta, $page, array $options = array())
    {
        if ($page < 0 || $page > $pagerfanta->count()) {
            throw new \InvalidArgumentException("Page '{$page}' is out of bounds");
        }

        $routeGenerator = $this->createRouteGenerator($options);

        return $routeGenerator($page);
    }

    /**
     * Creates an anonymous function which returns the URL for a given page.
     *
     * @param array $options
     *
     * @return callable
     *
     * @throws \Exception
     */
    private function createRouteGenerator($options = array())
    {
        $options = array_replace(array(
                'routeName'     => null,
                'routeParams'   => array(),
                'pageParameter' => '[page]',
            ), $options);

        $router = $this->container->get('router');

        if (null === $options['routeName']) {
            $request = $this->container->get('request');

            $options['routeName'] = $request->attributes->get('_route');
            if ('_internal' === $options['routeName']) {
                throw new \Exception('PagerfantaBundle can not guess the route when used in a subrequest');
            }
            
            // make sure we read the route parameters from the passed option array            
            $defaultRouteParams = array_merge($request->query->all(), $request->attributes->get('_route_params'));

            if (array_key_exists('routeParams', $options)) {
                $options['routeParams'] = array_merge($defaultRouteParams, $options['routeParams']);
            } else {
                $options['routeParams'] = $defaultRouteParams;
            }   
        }

        $routeName = $options['routeName'];
        $routeParams = $options['routeParams'];
        $pagePropertyPath = new PropertyPath($options['pageParameter']);

        return function($page) use($router, $routeName, $routeParams, $pagePropertyPath) {
            $propertyAccessor = PropertyAccess::getPropertyAccessor();
            $propertyAccessor->setValue($routeParams, $pagePropertyPath, $page);

            return $router->generate($routeName, $routeParams);
        };
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'pagerfanta';
    }
}
