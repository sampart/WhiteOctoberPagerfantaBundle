<?php

namespace Pablodip\ModuleTestBundle\Tests\Module;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PagerfantaControllerTest extends WebTestCase
{

    public function testDefaultView()
    {
        $this->assertView('default-view', <<<EOF
<nav>
    <span class="disabled">Previous</span>
    <span class="current">1</span>
    <a href="/pagerfanta/default-view?page=2">2</a>
    <a href="/pagerfanta/default-view?page=3">3</a>
    <a href="/pagerfanta/default-view?page=4">4</a>
    <a href="/pagerfanta/default-view?page=5">5</a>
    <span class="dots">...</span>
    <a href="/pagerfanta/default-view?page=10">10</a>
    <a href="/pagerfanta/default-view?page=2">Next</a>
</nav>
EOF
        );
    }

    public function testTwitterBootstrapView()
    {
        $this->assertView('twitter-bootstrap-view', <<<EOF
<div class="pagination">
    <ul>
        <li class="prev disabled"><span>&larr; Previous</span></li>
        <li class="active"><span>1</span></li>
        <li><a href="/pagerfanta/twitter-bootstrap-view?page=2">2</a></li>
        <li><a href="/pagerfanta/twitter-bootstrap-view?page=3">3</a></li>
        <li><a href="/pagerfanta/twitter-bootstrap-view?page=4">4</a></li>
        <li><a href="/pagerfanta/twitter-bootstrap-view?page=5">5</a></li>
        <li><a href="/pagerfanta/twitter-bootstrap-view?page=6">6</a></li>
        <li><a href="/pagerfanta/twitter-bootstrap-view?page=7">7</a></li>
        <li class="disabled"><span>&hellip;</span></li>
        <li><a href="/pagerfanta/twitter-bootstrap-view?page=10">10</a></li>
        <li class="next"><a href="/pagerfanta/twitter-bootstrap-view?page=2">Next &rarr;</a></li>
    </ul>
</div>
EOF
        );
    }

    public function testTwitterBootstrap3View()
    {
        $this->assertView('twitter-bootstrap3-view', <<<EOF
<ul class="pagination">
    <li class="prev disabled"><span>&larr; Previous</span></li>
    <li class="active"><span>1 <span class="sr-only">(current)</span></span></li>
    <li><a href="/pagerfanta/twitter-bootstrap3-view?page=2">2</a></li>
    <li><a href="/pagerfanta/twitter-bootstrap3-view?page=3">3</a></li>
    <li><a href="/pagerfanta/twitter-bootstrap3-view?page=4">4</a></li>
    <li><a href="/pagerfanta/twitter-bootstrap3-view?page=5">5</a></li>
    <li><a href="/pagerfanta/twitter-bootstrap3-view?page=6">6</a></li>
    <li><a href="/pagerfanta/twitter-bootstrap3-view?page=7">7</a></li>
    <li class="disabled"><span>&hellip;</span></li>
    <li><a href="/pagerfanta/twitter-bootstrap3-view?page=10">10</a></li>
    <li class="next"><a href="/pagerfanta/twitter-bootstrap3-view?page=2">Next &rarr;</a></li>
</ul>
EOF
        );
    }

    public function testViewWithOptions()
    {
        $this->assertView('view-with-options', <<<EOF
<nav>
    <span class="disabled">Previous</span>
    <span class="current">1</span>
    <a href="/pagerfanta/view-with-options?page=2">2</a>
    <a href="/pagerfanta/view-with-options?page=3">3</a>
    <span class="dots">...</span>
    <a href="/pagerfanta/view-with-options?page=10">10</a>
    <a href="/pagerfanta/view-with-options?page=2">Next</a>
</nav>
EOF
        );
    }

    public function testDefaultTranslatedView()
    {
        $this->assertView('default-translated-view', <<<EOF
<nav>
    <span class="disabled">&#171; Anterior</span>
    <span class="current">1</span>
    <a href="/pagerfanta/default-translated-view?page=2">2</a>
    <a href="/pagerfanta/default-translated-view?page=3">3</a>
    <a href="/pagerfanta/default-translated-view?page=4">4</a>
    <a href="/pagerfanta/default-translated-view?page=5">5</a>
    <span class="dots">...</span>
    <a href="/pagerfanta/default-translated-view?page=10">10</a>
    <a href="/pagerfanta/default-translated-view?page=2">Siguiente &#187;</a>
</nav>
EOF
        );
    }

    public function testTwitterBootstrapTranslatedView()
    {
        $this->assertView('twitter-bootstrap-translated-view', <<<EOF
<div class="pagination">
    <ul>
        <li class="prev disabled"><span>&larr; Anterior</span></li>
        <li class="active"><span>1</span></li>
        <li><a href="/pagerfanta/twitter-bootstrap-translated-view?page=2">2</a></li>
        <li><a href="/pagerfanta/twitter-bootstrap-translated-view?page=3">3</a></li>
        <li><a href="/pagerfanta/twitter-bootstrap-translated-view?page=4">4</a></li>
        <li><a href="/pagerfanta/twitter-bootstrap-translated-view?page=5">5</a></li>
        <li><a href="/pagerfanta/twitter-bootstrap-translated-view?page=6">6</a></li>
        <li><a href="/pagerfanta/twitter-bootstrap-translated-view?page=7">7</a></li>
        <li class="disabled"><span>&hellip;</span></li>
        <li><a href="/pagerfanta/twitter-bootstrap-translated-view?page=10">10</a></li>
        <li class="next"><a href="/pagerfanta/twitter-bootstrap-translated-view?page=2">Siguiente &rarr;</a></li>
    </ul>
</div>
EOF
        );
    }

    public function testTwitterBootstrap3TranslatedView()
    {
        $this->assertView('twitter-bootstrap3-translated-view', <<<EOF
<ul class="pagination">
    <li class="prev disabled"><span>&larr; Anterior</span></li>
    <li class="active"><span>1 <span class="sr-only">(current)</span></span></li>
    <li><a href="/pagerfanta/twitter-bootstrap3-translated-view?page=2">2</a></li>
    <li><a href="/pagerfanta/twitter-bootstrap3-translated-view?page=3">3</a></li>
    <li><a href="/pagerfanta/twitter-bootstrap3-translated-view?page=4">4</a></li>
    <li><a href="/pagerfanta/twitter-bootstrap3-translated-view?page=5">5</a></li>
    <li><a href="/pagerfanta/twitter-bootstrap3-translated-view?page=6">6</a></li>
    <li><a href="/pagerfanta/twitter-bootstrap3-translated-view?page=7">7</a></li>
    <li class="disabled"><span>&hellip;</span></li>
    <li><a href="/pagerfanta/twitter-bootstrap3-translated-view?page=10">10</a></li>
    <li class="next"><a href="/pagerfanta/twitter-bootstrap3-translated-view?page=2">Siguiente &rarr;</a></li>
</ul>
EOF
        );
    }

    public function testMyView1()
    {
        $this->assertView('my-view-1', <<<EOF
<nav>
    <span class="disabled">Anterior</span>
    <span class="current">1</span>
    <a href="/pagerfanta/my-view-1?page=2">2</a>
    <a href="/pagerfanta/my-view-1?page=3">3</a>
    <a href="/pagerfanta/my-view-1?page=4">4</a>
    <a href="/pagerfanta/my-view-1?page=5">5</a>
    <span class="dots">...</span>
    <a href="/pagerfanta/my-view-1?page=10">10</a>
    <a href="/pagerfanta/my-view-1?page=2">Siguiente</a>
</nav>
EOF
        );
    }

    public function testViewWithRouteParams()
    {
        $this->assertView('view-with-route-params', <<<EOF
<nav>
    <span class="disabled">Previous</span>
    <span class="current">1</span>
    <a href="/pagerfanta/view-with-route-params?test=im-a-test&page=2">2</a>
    <a href="/pagerfanta/view-with-route-params?test=im-a-test&page=3">3</a>
    <a href="/pagerfanta/view-with-route-params?test=im-a-test&page=4">4</a>
    <a href="/pagerfanta/view-with-route-params?test=im-a-test&page=5">5</a>
    <span class="dots">...</span><a href="/pagerfanta/view-with-route-params?test=im-a-test&page=10">10</a>
    <a href="/pagerfanta/view-with-route-params?test=im-a-test&page=2">Next</a>
</nav>
EOF
);

    }

    /**
     * @test
     */
    public function testOutOfRangeExceptionWithNoneStrategy()
    {
        $client = static::createClient();
        $client->request('GET', $this->buildViewUrl('custom-page?currentPage=51'));

        $response = $client->getResponse();
        $this->assertSame(404, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function testFirstPageLinkDoesHaveParam()
    {
        $this->assertView('custom-page?currentPage=2', <<<EOF
<nav>
    <a href="/pagerfanta/custom-page?currentPage=2&page=1">Previous</a>
    <a href="/pagerfanta/custom-page?currentPage=2&page=1">1</a>
    <span class="current">2</span>
    <a href="/pagerfanta/custom-page?currentPage=2&page=3">3</a>
    <a href="/pagerfanta/custom-page?currentPage=2&page=4">4</a>
    <a href="/pagerfanta/custom-page?currentPage=2&page=5">5</a>
    <span class="dots">...</span>
    <a href="/pagerfanta/custom-page?currentPage=2&page=10">10</a>
    <a href="/pagerfanta/custom-page?currentPage=2&page=3">Next</a>
</nav>
EOF
        );
    }

    /**
     * @test
     */
    public function testWithoutFirstPageParam()
    {
        $this->assertView('view-without-first-page-param?currentPage=2', <<<EOF
<nav>
    <a href="/pagerfanta/view-without-first-page-param?currentPage=2">Previous</a>
    <a href="/pagerfanta/view-without-first-page-param?currentPage=2">1</a>
    <span class="current">2</span>
    <a href="/pagerfanta/view-without-first-page-param?currentPage=2&page=3">3</a>
    <a href="/pagerfanta/view-without-first-page-param?currentPage=2&page=4">4</a>
    <a href="/pagerfanta/view-without-first-page-param?currentPage=2&page=5">5</a>
    <span class="dots">...</span>
    <a href="/pagerfanta/view-without-first-page-param?currentPage=2&page=10">10</a>
    <a href="/pagerfanta/view-without-first-page-param?currentPage=2&page=3">Next</a>
</nav>
EOF
        );
    }

    /**
     * @test
     */
    public function testWrongMaxPerPageExceptionWithNoneStrategy()
    {
        $client = static::createClient();
        $client->request('GET', $this->buildViewUrl('custom-page?maxPerPage=invalid'));

        $response = $client->getResponse();
        $this->assertSame(404, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function testOutOfRangeExceptionWithToHttpNotFoundStrategy()
    {
        $client = static::createClient(array('environment' => 'test_convert_exceptions'));

        $client->request('GET', $this->buildViewUrl('custom-page?currentPage=51'));

        $response = $client->getResponse();
        $this->assertSame(404, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function testWrongMaxPerPageExceptionWithToHttpNotFoundStrategy()
    {
        $client = static::createClient(array('environment' => 'test_convert_exceptions'));
        $client->request('GET', $this->buildViewUrl('custom-page?maxPerPage=invalid'));

        $response = $client->getResponse();
        $this->assertSame(404, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function testCorrectMaxPerPageAndCurrentPageWithNoneStrategy()
    {
        $client = static::createClient();
        $client->request('GET', $this->buildViewUrl('custom-page?maxPerPage=10&currentPage=1'));

        $response = $client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
    }

    private function assertView($view, $html)
    {
        $client = static::createClient();

        $crawler = $client->request('GET', $this->buildViewUrl($view));

        $response = $client->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame($this->removeWhitespacesBetweenTags($html), $response->getContent());
    }

    private function buildViewUrl($view)
    {
        return sprintf('/pagerfanta/%s', $view);
    }

    private function removeWhitespacesBetweenTags($string)
    {
        return preg_replace('/>\s+</', '><', $string);
    }
}
