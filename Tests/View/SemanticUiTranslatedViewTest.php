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

/**
 * @author Loïc Frémont <loic@mobizel.com>
 */
class SemanticUiTranslatedViewTest extends TranslatedViewTest
{
    protected function viewClass()
    {
        return 'Pagerfanta\View\SemanticUiView';
    }

    protected function translatedViewClass()
    {
        return 'WhiteOctober\PagerfantaBundle\View\SemanticUiTranslatedView';
    }

    protected function previousMessageOption()
    {
        return 'prev_message';
    }

    protected function nextMessageOption()
    {
        return 'next_message';
    }

    protected function buildPreviousMessage($text)
    {
        return sprintf('&larr; %s', $text);
    }

    protected function buildNextMessage($text)
    {
        return sprintf('%s &rarr;', $text);
    }

    protected function translatedViewName()
    {
        return 'semantic_ui_translated';
    }
}
