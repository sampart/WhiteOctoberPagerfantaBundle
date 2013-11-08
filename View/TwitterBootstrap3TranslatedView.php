<?php

/*
 * This file is part of the Pagerfanta package.
 *
 * (c) Pablo Díez <pablodip@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WhiteOctober\PagerfantaBundle\View;

/**
 * TwitterBootstrap3TranslatedView
 *
 * This view renders the twitter bootstrap3 view with the text translated.
 */
class TwitterBootstrap3TranslatedView extends TwitterBootstrapTranslatedView
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'twitter_bootstrap3_translated';
    }
}