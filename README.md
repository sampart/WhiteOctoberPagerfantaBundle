WhiteOctoberPagerfantaBundle
============================

Bundle to use [Pagerfanta](https://github.com/whiteoctober/Pagerfanta) with [Symfony2](https://github.com/symfony/symfony).

**Note:** If you are using a 2.0.x release of Symfony2, please use the `symfony2.0` branch of this bundle.  The master branch of this bundle tracks the Symfony2 master branch.

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

    {{ pagerfanta(my_pager, view_name, view_options) }}

The routes are generated automatically for the current route using the variable
"page" to propagate the page number. By default, the bundle uses the
*DefaultView* with the *default* name. The default syntax is:

    <div class="pagerfanta">
        {{ pagerfanta(my_pager) }}
    </div>

The bundle also has the *TwitterBootstrapView* with the *twitter_bootstrap* name.

If you want to use a custom template, add another argument

    <div class="pagerfanta">
        {{ pagerfanta(my_pager, 'my_template') }}
    </div>

With Options

    {{ pagerfanta(my_pager, 'default', { 'proximity': 2}) }}

See the Pagerfanta documentation for the list of the parameters.

Translate in your language
--------------------------

The bundle also offers two views to translate the *default* and the
*twitter bootstrap* views.

    {{ pagerfanta(pagerfanta, 'default_translated') }}

    {{ pagerfanta(pagerfanta, 'twitter_bootstrap_translated') }}

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

Sometimes you want to reuse options of a view in your project, and you don't
want to write them all the times you render a view, or you can have different
configurations for a view and you want to save them in a place to be able to
change them easily.

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

Configuration
-------------

It's possible to configure the default view for all rendering in your
configuration file:

    white_october_pagerfanta:
        default_view: my_view_1

Basic CSS for the default view
------------------------------

The bundles comes with a basic css for the default view to be able to use a
good paginator faster. Of course you can change it, use another one or
create your own view.

    <link rel="stylesheet" href="{{ asset('bundles/whiteoctoberpagerfanta/css/pagerfantaDefault.css') }}" type="text/css" media="all" />

Author
------

Pablo Díez - <pablodip@gmail.com>

License
-------

Pagerfanta is licensed under the MIT License. See the LICENSE file for full
details.

Sponsors
--------

[WhiteOctober](http://www.whiteoctober.co.uk/)
