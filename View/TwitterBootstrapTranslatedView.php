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

use Pagerfanta\PagerfantaInterface;
use Pagerfanta\View\TwitterBootstrapView;
use Pagerfanta\View\ViewInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * This view renders the twitter bootstrap view with texts translated.
 *
 * @author Pablo Díez <pablodip@gmail.com>
 */
class TwitterBootstrapTranslatedView implements ViewInterface
{
    private $view;
    private $translator;

    /**
     * Constructor.
     *
     * @param TwitterBootstrapView $view       A twitter bootstrap view.
     * @param TranslatorInterface  $translator A translator interface.
     */
    public function __construct(TwitterBootstrapView $view, TranslatorInterface $translator)
    {
        $this->view = $view;
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function render(PagerfantaInterface $pagerfanta, $routeGenerator, array $options = array())
    {
        if (!isset($options['prev_message'])) {
            $options['prev_message'] = '&larr; '.$this->translator->trans('previous', array(), 'pagerfanta');
        }
        if (!isset($options['next_message'])) {
            $options['next_message'] = $this->translator->trans('next', array(), 'pagerfanta').' &rarr;';
        }

        return $this->view->render($pagerfanta, $routeGenerator, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'twitter_bootstrap_translated';
    }
}
