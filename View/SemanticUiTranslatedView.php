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
 * SemanticUiTranslatedView
 *
 * This view renders the semantic ui view with the text translated.
 *
 * @author Loïc Frémont <loic@mobizel.com>
 */
class SemanticUiTranslatedView extends TranslatedView
{
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

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'semantic_ui_translated';
    }
}
