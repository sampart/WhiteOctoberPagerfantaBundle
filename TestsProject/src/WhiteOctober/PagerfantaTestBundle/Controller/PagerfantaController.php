<?php

namespace WhiteOctober\PagerfantaTestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\FixedAdapter;
use Symfony\Component\HttpFoundation\Request;

class PagerfantaController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function defaultViewAction()
    {
        return $this->renderPagerfanta('defaultView');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function twitterBootstrapViewAction()
    {
        return $this->renderPagerfanta('twitterBootstrapView');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function twitterBootstrap3ViewAction()
    {
        return $this->renderPagerfanta('twitterBootstrap3View');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewWithOptionsAction()
    {
        return $this->renderPagerfanta('viewWithOptions');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function defaultTranslatedViewAction()
    {
        $this->setLocale('es');

        return $this->renderPagerfanta('defaultTranslatedView');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function twitterBootstrapTranslatedViewAction()
    {
        $this->setLocale('es');

        return $this->renderPagerfanta('twitterBootstrapTranslatedView');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function twitterBootstrap3TranslatedViewAction()
    {
        $this->setLocale('es');

        return $this->renderPagerfanta('twitterBootstrap3TranslatedView');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function myView1Action()
    {
        return $this->renderPagerfanta('myView1');
    }

    /**
     * @param null $test
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewWithRouteParamsAction($test = null)
    {
        return $this->renderPagerfanta('viewWithRouteParams');
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function defaultWithRequestAction(Request $request)
    {
        $template = $this->buildTemplateName('defaultView');
        $pagerfanta = $this->createPagerfanta();
        $pagerfanta->setMaxPerPage($request->query->get('maxPerPage', 10));
        $pagerfanta->setCurrentPage($request->query->get('currentPage', 1));

        return $this->render($template, array(
            'pagerfanta' => $pagerfanta,
        ));
    }

    /**
     * @param $name
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    private function renderPagerfanta($name)
    {
        $template = $this->buildTemplateName($name);
        $pagerfanta = $this->createPagerfanta();

        return $this->render($template, array(
            'pagerfanta' => $pagerfanta
        ));

    }

    /**
     * @param $name
     *
     * @return string
     */
    private function buildTemplateName($name)
    {
        return sprintf('WhiteOctoberPagerfantaTestBundle:Pagerfanta:%s.html.twig', $name);
    }

    /**
     * @return Pagerfanta
     */
    private function createPagerfanta()
    {
        $adapter = $this->createAdapter();

        return new Pagerfanta($adapter);
    }

    /**
     * @return FixedAdapter
     */
    private function createAdapter()
    {
        $nbResults = 100;
        $results = range(1, $nbResults);

        return new FixedAdapter($nbResults, $results);
    }

    /**
     * @param $locale
     */
    private function setLocale($locale)
    {
        // getRequest method is deprecated since version 2.4, to be removed in 3.0
        $this->getRequest()->setLocale($locale);
    }
}
