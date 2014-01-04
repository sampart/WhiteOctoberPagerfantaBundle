<?php

namespace WhiteOctober\PagerfantaBundle\Tests\Twig;

use Mockery\MockInterface;
use Mockery;
use Symfony\Component\HttpFoundation\Request;
use WhiteOctober\PagerfantaBundle\Twig\PagerfantaExtension;
use Symfony\Component\DependencyInjection\Container;

class PagerfantaExtensionTest extends \PHPUnit_Framework_TestCase
{
    /** @var MockInterface */
    private $routeGeneratorCreator;

    /** @var MockInterface */
    private $viewFactory;

    private $defaultView;
    /** @var Container */
    private $container;

    /** @var PagerfantaExtension */
    private $extension;

    protected function setUp()
    {
        $this->routeGeneratorCreator = Mockery::mock('WhiteOctober\PagerfantaBundle\Routing\PagerfantaRouteGeneratorCreator');
        $this->viewFactory = Mockery::mock('Pagerfanta\View\ViewFactoryInterface');
        $this->defaultView = 'foo';
        $this->container = new Container();

        $this->extension = new PagerfantaExtension($this->routeGeneratorCreator, $this->viewFactory, $this->defaultView, $this->container);
    }

    public function testRenderPagerfanta()
    {
        $routeName = 'ups';
        $routeParams = array('a' => 1);
        $pageParam = '[page]';
        $result = 'foobar';

        $pagerfanta = Mockery::mock('Pagerfanta\Pagerfanta');

        $request = new Request();
        $request->attributes->set('_route', $routeName);
        $request->attributes->set('_route_params', $routeParams);
        $this->container->set('request', $request);

        $routeGenerator = new \stdClass();
        $this->routeGeneratorCreator->shouldReceive('create')->with($routeName, $routeParams, $pageParam)->once()->andReturn($routeGenerator);

        $view = Mockery::mock('Pagerfanta\View\ViewInterface');
        $view->shouldReceive('render')->with($pagerfanta, $routeGenerator, array())->once()->andReturn($result);

        $this->viewFactory->shouldReceive('get')->with($this->defaultView)->once()->andReturn($view);

        $this->assertSame($result, $this->extension->renderPagerfanta($pagerfanta));
    }
}
