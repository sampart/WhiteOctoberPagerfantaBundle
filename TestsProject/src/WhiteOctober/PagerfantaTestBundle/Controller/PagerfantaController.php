<?php

namespace WhiteOctober\PagerfantaTestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\FixedAdapter;
use Symfony\Component\HttpFoundation\Request;

class PagerfantaController extends Controller
{
    public function defaultViewAction()
    {
        return $this->renderPagerfanta('defaultView');
    }

    public function twitterBootstrapViewAction()
    {
        return $this->renderPagerfanta('twitterBootstrapView');
    }

    public function twitterBootstrap3ViewAction()
    {
        return $this->renderPagerfanta('twitterBootstrap3View');
    }

    public function viewWithOptionsAction()
    {
        return $this->renderPagerfanta('viewWithOptions');
    }

    public function viewWithoutFirstPageParamAction(Request $request)
    {
        return $this->defaultWithRequestAction($request, 'viewWithoutFirstPageParam');
    }

    public function defaultTranslatedViewAction()
    {
        return $this->renderPagerfanta('defaultTranslatedView');
    }

    public function twitterBootstrapTranslatedViewAction()
    {
        return $this->renderPagerfanta('twitterBootstrapTranslatedView');
    }

    public function twitterBootstrap3TranslatedViewAction()
    {
        return $this->renderPagerfanta('twitterBootstrap3TranslatedView');
    }

    public function myView1Action()
    {
        return $this->renderPagerfanta('myView1');
    }

    public function viewWithRouteParamsAction($test = null)
    {
        return $this->renderPagerfanta('viewWithRouteParams');
    }

    public function defaultWithRequestAction(Request $request, $name = 'defaultView')
    {
        $template = $this->buildTemplateName($name);
        $pagerfanta = $this->createPagerfanta();
        $pagerfanta->setMaxPerPage($request->query->get('maxPerPage', 10));
        $pagerfanta->setCurrentPage($request->query->get('currentPage', 1));

        return $this->render($template, array(
            'pagerfanta' => $pagerfanta,
        ));
    }

    private function renderPagerfanta($name)
    {
        $template = $this->buildTemplateName($name);
        $pagerfanta = $this->createPagerfanta();

        return $this->render($template, array(
            'pagerfanta' => $pagerfanta
        ));

    }

    private function buildTemplateName($name)
    {
        return sprintf('WhiteOctoberPagerfantaTestBundle:Pagerfanta:%s.html.twig', $name);
    }

    private function createPagerfanta()
    {
        $adapter = $this->createAdapter();

        return new Pagerfanta($adapter);
    }

    private function createAdapter()
    {
        $nbResults = 100;
        $results = range(1, $nbResults);

        return new FixedAdapter($nbResults, $results);
    }
}
