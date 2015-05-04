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
 * This view renders the twitter bootstrap view with texts translated.
 *
 * @author Pablo Díez <pablodip@gmail.com>
 */
class TwitterBootstrapTranslatedView extends TranslatedView
{
    /**
     * @return string
     */
    protected function previousMessageOption()
    {
        return 'prev_message';
    }

    /**
     * @return string
     */
    protected function nextMessageOption()
    {
        return 'next_message';
    }

    /**
     * @param string $text
     *
     * @return string
     */
    protected function buildPreviousMessage($text)
    {
        return sprintf('&larr; %s', $text);
    }

    /**
     * @param string $text
     *
     * @return string
     */
    protected function buildNextMessage($text)
    {
        return sprintf('%s &rarr;', $text);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'twitter_bootstrap_translated';
    }
}