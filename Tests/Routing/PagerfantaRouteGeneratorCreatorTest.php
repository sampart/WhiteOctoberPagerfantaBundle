<?php

namespace WhiteOctober\PagerfantaBundle\Tests\Routing;

use Mockery;
use WhiteOctober\PagerfantaBundle\Routing\PagerfantaRouteGenerator;
use WhiteOctober\PagerfantaBundle\Routing\PagerfantaRouteGeneratorCreator;
use Mockery\MockInterface;

class PagerfantaRouteGeneratorCreatorTest extends \PHPUnit_Framework_TestCase
{
    /** @var MockInterface */
    private $urlGenerator;

    /** @var PagerfantaRouteGeneratorCreator */
    private $creator;

    protected function setUp()
    {
        $this->urlGenerator = Mockery::mock('Symfony\Component\Routing\Generator\UrlGeneratorInterface');

        $this->creator = new PagerfantaRouteGeneratorCreator($this->urlGenerator);
    }

    public function testGenerate()
    {
        $routeName = 'foo';
        $routeParams = array('a' => '1');
        $pageParameter = '[page]';

        $result = new PagerfantaRouteGenerator($this->urlGenerator, $routeName, $routeParams, $pageParameter);

        $this->assertEquals($result, $this->creator->create($routeName, $routeParams, $pageParameter));
    }
}
