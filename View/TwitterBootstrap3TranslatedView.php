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

use WhiteOctober\PagerfantaBundle\View\DefaultTranslatedView;
use Pagerfanta\View\TwitterBootstrap3View;
use Symfony\Component\Translation\TranslatorInterface;
use Pagerfanta\View\ViewInterface;
use Pagerfanta\PagerfantaInterface;

/**
 * TwitterBootstrap3TranslatedView
 *
 * This view renders the twitter bootstrap3 view with the text translated
 */
class TwitterBootstrap3TranslatedView extends DefaultTranslatedView implements ViewInterface
{
    protected $view;
    protected $translator;

    /**
     * Constructor.
     *
     * @param TwitterBootstrap3View $view       A Twitter bootstrap3 view
     * @param TranslatorInterface   $translator A translator interface
     */
    public function __construct(TwitterBootstrap3View $view, TranslatorInterface $translator)
    {

        $this->view = $view;
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'twitter_bootstrap3_translated';
    }

    /**
     * {@inheritdoc}
     */
    public function render(PagerfantaInterface $pagerfanta, $routeGenerator, array $options = array())
    {
        if (!isset($options['prev_message'])) {
            $options['prev_message'] = '&larr; ' . $this->translator->trans('previous', array(), 'pagerfanta');
        }
        if (!isset($options['next_message'])) {
            $options['next_message'] = $this->translator->trans('next', array(), 'pagerfanta') . ' &rarr;';
        }

        return $this->view->render($pagerfanta, $routeGenerator, $options);
    }

}
