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

abstract class TranslatedViewTest extends \PHPUnit_Framework_TestCase
{
    private $view;
    private $translator;

    private $translatedView;

    private $pagerfanta;
    private $routeGenerator;

    protected function setUp()
    {
        $this->view = $this->createViewMock();
        $this->translator = $this->createTranslatorMock();

        $this->translatedView = $this->createTranslatedView();

        $this->pagerfanta = $this->createPagerfantaMock();
        $this->routeGenerator = $this->createRouteGenerator();
    }

    private function createViewMock()
    {
        return $this->getMock($this->viewClass());
    }

    abstract protected function viewClass();

    private function createTranslatorMock()
    {
        return $this->getMock('Symfony\Component\Translation\TranslatorInterface');
    }

    private function createTranslatedView()
    {
        $class = $this->translatedViewClass();

        return new $class($this->view, $this->translator);
    }

    abstract protected function translatedViewClass();

    private function createPagerfantaMock()
    {
        return $this->getMockBuilder('Pagerfanta\Pagerfanta')
            ->disableOriginalConstructor()
            ->getMock();
    }

    private function createRouteGenerator()
    {
        return function () { };
    }

    public function testRenderShouldTranslatePreviuosAndNextMessage()
    {
        $this->translatorExpectsPreviousAt(0);
        $this->translatorExpectsNextAt(1);

        $options = array();

        $this->assertRender($options);
    }

    public function testRenderAllowsCustomizingPreviousMessageWithOption()
    {
        $this->translatorExpectsNextAt(0);

        $previousMessageOption = $this->previousMessageOption();
        $options = array($previousMessageOption => $this->previousMessage());

        $this->assertRender($options);
    }

    public function testRenderAllowsCustomizingNextMessageWithOption()
    {
        $this->translatorExpectsPreviousAt(0);

        $nextMessageOption = $this->nextMessageOption();
        $options = array($nextMessageOption => $this->nextMessage());

        $this->assertRender($options);
    }

    private function translatorExpectsPreviousAt($at)
    {
        $previous = $this->previous();

        $this->translator
            ->expects($this->at($at))
            ->method('trans')
            ->with('previous', array(), 'pagerfanta')
            ->will($this->returnValue($previous));
    }

    private function translatorExpectsNextAt($at)
    {
        $next = $this->next();

        $this->translator
            ->expects($this->at($at))
            ->method('trans')
            ->with('next', array(), 'pagerfanta')
            ->will($this->returnValue($next));
    }

    private function assertRender($options)
    {
        $previousMessageOption = $this->previousMessageOption();
        $nextMessageOption = $this->nextMessageOption();

        $previous = $this->previous();
        $next = $this->next();

        $expectedOptions = array(
            $previousMessageOption => $this->buildPreviousMessage($previous),
            $nextMessageOption => $this->buildNextMessage($next)
        );

        $result = new \stdClass();

        $this->view
            ->expects($this->once())
            ->method('render')
            ->with($this->pagerfanta, $this->routeGenerator, $expectedOptions)
            ->will($this->returnvalue($result));

        $rendered = $this->translatedView->render($this->pagerfanta, $this->routeGenerator, $options);

        $this->assertSame($result, $rendered);
    }

    abstract protected function previousMessageOption();

    abstract protected function nextMessageOption();

    private function previous()
    {
        return 'Anterior';
    }

    private function next()
    {
        return 'Siguiente';
    }

    private function previousMessage()
    {
        return $this->buildPreviousMessage($this->previous());
    }

    private function nextMessage()
    {
        return $this->buildNextMessage($this->next());
    }

    abstract protected function buildPreviousMessage($text);

    abstract protected function buildNextMessage($text);

    public function testGetNameShouldReturnTheName()
    {
        $name = $this-> translatedViewName();

        $this->assertSame($name, $this->translatedView->getName());
    }

    abstract protected function translatedViewName();
}