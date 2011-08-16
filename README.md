WhiteOctoberPagerfantaBundle
============================

Bundle to use [Pagerfanta](https://github.com/whiteoctober/Pagerfanta) with [Symfony2](https://github.com/symfony/symfony).

The bundle includes:

  * Twig function to render pagerfantas with views and options.
  * Way to use easily views.
  * Way to reuse options in views.
  * Basic CSS for the DefaultView.

Installation
------------

Add Pagerfanta and WhiteOctoberPagerfantaBundle to your vendors:

    git submodule add http://github.com/whiteoctober/Pagerfanta.git vendor/pagerfanta
    git submodule add http://github.com/whiteoctober/WhiteOctoberPagerfantaBundle.git vendor/bundles/WhiteOctober/PagerfantaBundle

Add both to your autoload:

    // app/autoload.php
    $loader->registerNamespaces(array(
        // ...
        'WhiteOctober\PagerfantaBundle' => __DIR__.'/../vendor/bundles',
        'Pagerfanta'                    => __DIR__.'/../vendor/pagerfanta/src',
        // ...
    ));

Add the WhiteOctoberPagerfantaBundle to your application kernel:

    // app/AppKernel.php
    public function registerBundles()
    {
        return array(
            // ...
            new WhiteOctober\PagerfantaBundle\WhiteOctoberPagerfantaBundle(),
            // ...
        );
    }

Rendering pagerfantas
---------------------

    {{ pagerfanta(pagerfanta, view_name, view_options) }}

The routes are generated automatically for the current route using the variable "page" to propagate the page number.

The bundle comes with the *DefaultView* with with the *default* name.

    <div class="pagerfanta">
        {{ pagerfanta(pagerfanta, 'default') }}
    </div>

With Options

    {{ pagerfanta(pagerfanta, 'default', { 'proximity': 2}) }}

Translate in your language
--------------------------

The bundle offers a second view called *translated* which is the same as the *default* but with texts translated into the user language.

    {{ pagerfanta(pagerfanta, 'translated') }}

Adding Views
------------

The views are added to the container with the *pagerfanta.view* tag:

XML

    <service id="pagerfanta.view.default" class="Pagerfanta\View\DefaultView" public="false">
        <tag name="pagerfanta.view" alias="default" />
    </service>

YAML

    services:
        pagerfanta.view.default:
            class: Pagerfanta\View\DefaultView
            public: false
            tags: [{ name: pagerfanta.view, alias: default }]

Reusing Options
---------------

Sometimes you want to reuse options of a view in your project, and you don't want to write them all the times you render a view, or you can have different configurations for a view and you want to save them in a place to be able to change them easily.

For this you have to define views with the special view *OptionableView*:

    services:
        pagerfanta.view.my_view_1:
            class: Pagerfanta\View\OptionableView
            arguments:
                - @pagerfanta.view.default
                - { proximity: 2, previous_message: Anterior, next_message: Siguiente }
            public: false
            tags: [{ name: pagerfanta.view, alias: my_view_1 }]
        pagerfanta.view.my_view_2:
            class: Pagerfanta\View\OptionableView
            arguments:
                - @pagerfanta.view.default
                - { proximity: 5 }
            public: false
            tags: [{ name: pagerfanta.view, alias: my_view_2 }]

And using then:

    {{ pagerfanta(pagerfanta, 'my_view_1') }}
    {{ pagerfanta(pagerfanta, 'my_view_2') }}

The easiest way to render pagerfantas (or paginators!) ;)

Basic CSS for the default view
------------------------------

The bundles comes with a basic css for the default view to be able to use a good paginator faster. Of course you can change it, use another one or create your own view.

    <link rel="stylesheet" href="{{ asset('bundles/whiteoctoberpagerfanta/css/pagerfantaDefault.css') }}" type="text/css" media="all" />

Author
------

Pablo Díez - <pablodip@gmail.com>

License
-------

Pagerfanta is licensed under the MIT License. See the LICENSE file for full details.

Sponsors
--------

[WhiteOctober](http://www.whiteoctober.co.uk/)
