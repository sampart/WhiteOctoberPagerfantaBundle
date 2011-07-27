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
use Pagerfanta\View\ViewInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Translated view.
 * 
 * This view renders the default view with texts translated to the user language.
 * 
 * @author Jérôme Tamarelle <jerome@tamarelle.net>
 */
class TranslatedView implements ViewInterface
{
    /**
     * @var \Pagerfanta\View\ViewInterface
     */
    private $view;

    /**
     * @var \Symfony\Component\Translation\TranslatorInterface
     */
    private $translator;

    /**
     * Constructor.
     *
     * @param ViewInterface       $view
     * @param TranslatorInterface $translator
     */
    public function __construct(ViewInterface $view, TranslatorInterface $translator)
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
            $options['previous_message'] = $this->translator->trans('pagerfanta.previous');
        }

        if (!isset($options['next_message'])) {
            $options['next_message'] = $this->translator->trans('pagerfanta.next');
        }

        return $this->view->render($pagerfanta, $routeGenerator, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'translated';
    }
}
