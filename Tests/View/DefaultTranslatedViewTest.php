<?php

/*
 * This file is part of the Pagerfanta package.
 *
 * (c) Pablo Díez <pablodip@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WhiteOctober\PagerfantaBundle\Tests\View;

class DefaultTranslatedViewTest extends TranslatedViewTest
{
    protected function viewClass()
    {
        return 'Pagerfanta\View\DefaultView';
    }

    protected function translatedViewClass()
    {
        return 'WhiteOctober\PagerfantaBundle\View\DefaultTranslatedView';
    }

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

    protected function translatedViewName()
    {
        return 'default_translated';
    }
}