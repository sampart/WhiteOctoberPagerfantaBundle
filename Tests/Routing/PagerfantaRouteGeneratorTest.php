<?php

namespace WhiteOctober\PagerfantaBundle\Tests\Routing;

use Mockery;
use WhiteOctober\PagerfantaBundle\Routing\PagerfantaRouteGenerator;

class PagerfantaRouteGeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function testInvoke()
    {
        $urlGenerator = Mockery::mock('Symfony\Component\Routing\Generator\UrlGeneratorInterface');
        $routeName = 'foo';
        $routeParams = array('a' => '1');
        $pageParameter = '[page]';

        $page = 2;
        $routeParamsWithPage = array_merge($routeParams, array('page' => $page));

        $generator = new PagerfantaRouteGenerator($urlGenerator, $routeName, $routeParams, $pageParameter);

        $result = 'blahblahblah';
        $urlGenerator->shouldReceive('generate')->with($routeName, $routeParamsWithPage)->once()->andReturn($result);

        $this->assertSame($result, $generator($page));
    }
}
