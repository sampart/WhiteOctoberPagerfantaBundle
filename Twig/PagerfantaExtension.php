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

use Pagerfanta\PagerfantaInterface;
use Pagerfanta\View\ViewFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyPath;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * PagerfantaExtension.
 *
 * @author Pablo Díez <pablodip@gmail.com>
 */
class PagerfantaExtension extends \Twig_Extension
{
    private $defaultView;
    private $viewFactory;
    private $router;
    private $requestStack;
    private $request;

    public function __construct($defaultView, ViewFactory $viewFactory, UrlGeneratorInterface $router, RequestStack $requestStack = null)
    {
        $this->defaultView = $defaultView;
        $this->viewFactory = $viewFactory;
        $this->router = $router;
        $this->requestStack = $requestStack;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('pagerfanta', array($this, 'renderPagerfanta'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('pagerfanta_page_url', array($this, 'getPageUrl')),
        );
    }

    /**
     * Renders a pagerfanta.
     *
     * @param PagerfantaInterface $pagerfanta The pagerfanta.
     * @param string|array        $viewName   The view name.
     * @param array               $options    An array of options (optional).
     *
     * @return string The pagerfanta rendered.
     */
    public function renderPagerfanta(PagerfantaInterface $pagerfanta, $viewName = null, array $options = array())
    {
        if (is_array($viewName)) {
            list($viewName, $options) = array(null, $viewName);
        }

        $viewName = $viewName ?: $this->defaultView;

        $routeGenerator = $this->createRouteGenerator($options);

        return $this->viewFactory->get($viewName)->render($pagerfanta, $routeGenerator, $options);
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
        if ($page < 0 || $page > $pagerfanta->getNbPages()) {
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
                'omitFirstPage' => false
            ), $options);

        $router = $this->router;

        if (null === $options['routeName']) {
            $request = $this->getRequest();

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

        $routeName = $options['routeName'];
        $routeParams = $options['routeParams'];
        $pagePropertyPath = new PropertyPath($options['pageParameter']);
        $omitFirstPage = $options['omitFirstPage'];

        return function($page) use($router, $routeName, $routeParams, $pagePropertyPath, $omitFirstPage) {
            $propertyAccessor = PropertyAccess::createPropertyAccessor();
            if($omitFirstPage){
                $propertyAccessor->setValue($routeParams, $pagePropertyPath, $page > 1 ? $page : null);
            } else {
                $propertyAccessor->setValue($routeParams, $pagePropertyPath, $page);
            }

            return $router->generate($routeName, $routeParams);
        };
    }

    public function setRequest(Request $request = null)
    {
        $this->request = $request;
    }

    /**
     * @return Request|null
     */
    private function getRequest()
    {
        if ($this->requestStack && $request = $this->requestStack->getCurrentRequest()) {
            return $request;
        }

        return $this->request;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'pagerfanta';
    }
}
