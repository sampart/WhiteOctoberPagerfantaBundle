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
 * Translated view.
 *
 * This view renders the default view with texts translated to the user language.
 *
 * @author Jérôme Tamarelle <jerome@tamarelle.net>
 */
class DefaultTranslatedView extends TranslatedView
{
    protected function previousMessageOption()
    {
        return 'previous_message';
    }

    protected function nextMessageOption()
    {
        return 'next_message';
    }

    protected function buildPreviousMessage($text)
    {
        return sprintf('&#171; %s', $text);
    }

    protected function buildNextMessage($text)
    {
        return sprintf('%s &#187;', $text);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'default_translated';
    }
}
