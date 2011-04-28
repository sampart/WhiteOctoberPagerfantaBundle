<?php

/*
 * This file is part of the Pagerfanta package.
 *
 * (c) Pablo Díez <pablodip@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WhiteOctober\PagerfantaBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use WhiteOctober\PagerfantaBundle\DependencyInjection\Compiler\AddPagerfantasPass;

/**
 * WhiteOctoberPagerfantaBundle.
 *
 * @author Pablo Díez <pablodip@gmail.com>
 */
class WhiteOctoberPagerfantaBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new AddPagerfantasPass());
    }
}
