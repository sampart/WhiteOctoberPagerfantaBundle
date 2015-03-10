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
 * @author Pablo Díez <pablodip@gmail.com>
 */
abstract class TranslatedView implements ViewInterface
{
    private $view;
    private $translator;

    /**
     * Constructor.
     *
     * @param ViewInterface       $view       A view.
     * @param TranslatorInterface $translator A translator interface.
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
        $optionsWithTranslations = $this->addTranslationOptions($options);

        return $this->view->render($pagerfanta, $routeGenerator, $optionsWithTranslations);
    }

    /**
     * @param $options
     *
     * @return array
     */
    private function addTranslationOptions($options)
    {
        return $this->addNextTranslationOption(
            $this->addPreviousTranslationOption($options)
        );
    }

    /**
     * @param $options
     *
     * @return array
     */
    private function addPreviousTranslationOption($options)
    {
        $option = $this->previousMessageOption();
        $messageMethod = 'previousMessage';

        return $this->addTranslationOption($options, $option, $messageMethod);
    }

    /**
     * @param $options
     *
     * @return array
     */
    private function addNextTranslationOption($options)
    {
        $option = $this->nextMessageOption();
        $messageMethod = 'nextMessage';

        return $this->addTranslationOption($options, $option, $messageMethod);
    }

    /**
     * @param $options
     * @param $option
     * @param $messageMethod
     *
     * @return array
     */
    private function addTranslationOption($options, $option, $messageMethod)
    {
        if (isset($options[$option])) {
            return $options;
        }

        $message = $this->$messageMethod();

        return array_merge($options, array($option => $message));
    }

    abstract protected function previousMessageOption();

    abstract protected function nextMessageOption();

    /**
     * @return mixed
     */
    private function previousMessage()
    {
        $previousText = $this->previousText();

        return $this->buildPreviousMessage($previousText);
    }

    /**
     * @return mixed
     */
    private function nextMessage()
    {
        $nextText = $this->nextText();

        return $this->buildNextMessage($nextText);
    }

    /**
     * @return string
     */
    private function previousText()
    {
        return $this->translator->trans('previous', array(), 'pagerfanta');
    }

    /**
     * @return string
     */
    private function nextText()
    {
        return $this->translator->trans('next', array(), 'pagerfanta');
    }

    /**
     * @param $text
     *
     * @return mixed
     */
    abstract protected function buildPreviousMessage($text);

    /**
     * @param $text
     *
     * @return mixed
     */
    abstract protected function buildNextMessage($text);
}
