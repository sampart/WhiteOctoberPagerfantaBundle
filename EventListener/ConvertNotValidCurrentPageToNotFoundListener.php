<?php
namespace  WhiteOctober\PagerfantaBundle\EventListener;

use Pagerfanta\Exception\NotValidCurrentPageException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class ConvertNotValidCurrentPageToNotFoundListener implements EventSubscriberInterface
{
    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onException(GetResponseForExceptionEvent $event)
    {
        if ($event->getException() instanceof NotValidCurrentPageException) {
            $event->setException(new NotFoundHttpException('Page Not Found', $event->getException()));
        }
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::EXCEPTION => array('onException', 512)
        );
    }
}