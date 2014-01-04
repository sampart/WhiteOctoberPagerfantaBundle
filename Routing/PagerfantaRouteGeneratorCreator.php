<?php

/*
 * This file is part of the Pagerfanta package.
 *
 * (c) Pablo Díez <pablodip@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WhiteOctober\PagerfantaBundle\Routing;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PagerfantaRouteGeneratorCreator
{
    private $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function create($routeName, $routeParams, $pageParam)
    {
        return new PagerfantaRouteGenerator($this->urlGenerator, $routeName, $routeParams, $pageParam);
    }
}
