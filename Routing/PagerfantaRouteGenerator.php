<?php

namespace WhiteOctober\PagerfantaBundle\Routing;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PagerfantaRouteGenerator
{
    private $urlGenerator;

    private $routeName;
    private $routeParams;
    private $pageParam;

    public function __construct(UrlGeneratorInterface $urlGenerator, $routeName, $routeParams, $pageParam)
    {
        $this->urlGenerator = $urlGenerator;
        $this->routeName = $routeName;
        $this->routeParams = $routeParams;
        $this->pageParam = $pageParam;
    }

    public function __invoke($page)
    {
        $propertyAccessor = PropertyAccess::getPropertyAccessor();
        $propertyAccessor->setValue($this->routeParams, $this->pageParam, $page);

        return $this->urlGenerator->generate($this->routeName, $this->routeParams);
    }
}
