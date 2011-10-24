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
use Pagerfanta\View\DefaultView;
use Pagerfanta\View\ViewInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Translated view.
 *
 * This view renders the default view with texts translated to the user language.
 *
 * @author Jérôme Tamarelle <jerome@tamarelle.net>
 */
class DefaultTranslatedView implements ViewInterface
{
    private $view;
    private $translator;

    /**
     * Constructor.
     *
     * @param DefaultViewInterface       $view       A default view.
     * @param TranslatorInterface $translator A translator interface.
     */
    public function __construct(DefaultView $view, TranslatorInterface $translator)
    {
        $this->view = $view;
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function render(PagerfantaInterface $pagerfanta, $routeGenerator, array $options = array())
    {
        if (!isset($options['previous_message'])) {
            $options['previous_message'] = '&#171; '.$this->translator->trans('previous', array(), 'pagerfanta');
        }
        if (!isset($options['next_message'])) {
            $options['next_message'] = $this->translator->trans('next', array(), 'pagerfanta').' &#187;';
        }

        return $this->view->render($pagerfanta, $routeGenerator, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'default_translated';
    }
}
