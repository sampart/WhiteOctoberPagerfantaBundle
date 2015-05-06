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

use Pagerfanta\View\ViewFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Pagerfanta\PagerfantaInterface;
use WhiteOctober\PagerfantaBundle\Routing\PagerfantaRouteGeneratorCreator;

/**
 * PagerfantaExtension.
 *
 * @author Pablo Díez <pablodip@gmail.com>
 */
class PagerfantaExtension extends \Twig_Extension
{
    private $routeGeneratorCreator;
    private $viewFactory;
    private $defaultView;
    private $container;

    public function __construct(PagerfantaRouteGeneratorCreator $routeGeneratorCreator, ViewFactoryInterface $viewFactory, $defaultView, ContainerInterface $container)
    {
        $this->routeGeneratorCreator = $routeGeneratorCreator;
        $this->viewFactory = $viewFactory;
        $this->defaultView = $defaultView;
        $this->container = $container; // hack for not being able to inject the request
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
        $view = $viewName ?: $this->defaultView;
        $routeGenerator = $this->createRouteGenerator($options);

        return $this->viewFactory->get($view)->render($pagerfanta, $routeGenerator, $options);
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

        $request = $this->getRequest();

        if (null === $options['routeName']) {
            $options['routeName'] = $request->attributes->get('_route');
            if ('_internal' === $options['routeName']) {
                throw new \Exception('PagerfantaBundle can not guess the route when used in a subrequest');
            }
            
            // make sure we read the route parameters from the passed option array            
            $defaultRouteParams = array_merge($request->query->all(), $request->attributes->get('_route_params', array()));

            if (array_key_exists('routeParams', $options)) {
                $options['routeParams'] = array_merge($defaultRouteParams, $options['routeParams']);
            } else {
                $options['routeParams'] = $defaultRouteParams;
            }   
        }

        return $this->routeGeneratorCreator->create($options['routeName'], $options['routeParams'], $options['pageParameter']);
    }

    /** @return Request */
    private function getRequest()
    {
        return $this->container->get('request');
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'pagerfanta';
    }
}
