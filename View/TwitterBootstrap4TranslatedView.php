<?php

/*
 * This file is part of the Pagerfanta package.
 *
 * (c) Pablo Díez <pablodip@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Wenming Tang <wenming@cshome.com>
 */

namespace WhiteOctober\PagerfantaBundle\View;

/**
 * TwitterBootstrap4TranslatedView
 *
 * This view renders the twitter bootstrap4 view with the text translated.
 */
class TwitterBootstrap4TranslatedView extends TwitterBootstrapTranslatedView
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'twitter_bootstrap4_translated';
    }
}
