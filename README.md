# WhiteOctoberPagerfantaBundle

[![Build Status](https://travis-ci.org/whiteoctober/WhiteOctoberPagerfantaBundle.png?branch=master)](https://travis-ci.org/whiteoctober/WhiteOctoberPagerfantaBundle) [![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/whiteoctober/WhiteOctoberPagerfantaBundle/badges/quality-score.png?s=5bbc990b8c05b7dcc69cd0cfe7d8d46e9944c530)](https://scrutinizer-ci.com/g/whiteoctober/WhiteOctoberPagerfantaBundle/) [![SensioLabsInsight](https://insight.sensiolabs.com/projects/e0838383-1c8d-406f-9874-a76c08b7d217/mini.png)](https://insight.sensiolabs.com/projects/e0838383-1c8d-406f-9874-a76c08b7d217)

Bundle to use [Pagerfanta](https://github.com/whiteoctober/Pagerfanta) with [Symfony2](https://github.com/symfony/symfony).

**Note:** If you are using a 2.0.x release of Symfony2, please use the `symfony2.0` branch of this bundle.  The master branch of this bundle tracks the Symfony2 master branch.

The bundle includes:

  * Twig function to render pagerfantas with views and options.
  * Way to use easily views.
  * Way to reuse options in views.
  * Basic CSS for the DefaultView.

Installation
------------

1) Use [Composer](https://getcomposer.org/) to download the library

```
php composer.phar require white-october/pagerfanta-bundle
```

2) Then add the WhiteOctoberPagerfantaBundle to your application kernel:

```php
// app/AppKernel.php
public function registerBundles()
{
    return array(
        // ...
        new WhiteOctober\PagerfantaBundle\WhiteOctoberPagerfantaBundle(),
        // ...
    );
}
```

3) Configure and use things!

A) **Creating a Pager** is shown on the [Pagerfanta](https://github.com/whiteoctober/Pagerfanta) documentation. If you're using the Doctrine ORM, you'll want to use the [DoctrineORMAdapter](https://github.com/whiteoctober/Pagerfanta#doctrineormadapter)

B) **Rendering in Twig** is shown below in the [Rendering pagerfantas](#rendering-pagerfantas) section.

C) **Configuration** is shown through this document

Making Bad Page Numbers Return a 404
------------------------------------

Right now when the page is out of range or not a number, the server returns a 500 response. You can set the following parameter to show a 404 exception when the requested page is not valid instead.
It is set to "false" by defauly to provide backwards-compatibility (before it was 500).

```yml
// app/config/config.yml
white_october_pagerfanta:
    exceptions_strategy:
        out_of_range_page:        to_http_not_found
        not_valid_current_page:   to_http_not_found
```

Rendering pagerfantas
---------------------

```twig
    {{ pagerfanta(my_pager, view_name, view_options) }}
```

The routes are generated automatically for the current route using the variable
"page" to propagate the page number. By default, the bundle uses the
*DefaultView* with the *default* name. The default syntax is:

```twig
<div class="pagerfanta">
    {{ pagerfanta(my_pager) }}
</div>
```

### Twitter Bootstrap

The bundle also has TwitterBootstrapView.

For Bootstrap 2:

```twig
<div class="pagerfanta">
    {{ pagerfanta(my_pager, 'twitter_bootstrap') }}
</div>
```

For Bootstrap 3:

```twig
<div class="pagerfanta">
    {{ pagerfanta(my_pager, 'twitter_bootstrap3') }}
</div>
```

### Custom template


If you want to use a custom template, add another argument

```twig
<div class="pagerfanta">
    {{ pagerfanta(my_pager, 'my_template') }}
</div>
```

With Options

```twig
{{ pagerfanta(my_pager, 'default', { 'proximity': 2}) }}
```

See the Pagerfanta documentation for the list of the parameters.

Translate in your language
--------------------------

The bundle also offers two views to translate the *default* and the
*twitter bootstrap* views.

```twig
{{ pagerfanta(pagerfanta, 'default_translated') }}

{{ pagerfanta(pagerfanta, 'twitter_bootstrap_translated') }}
```

Adding Views
------------

The views are added to the container with the *pagerfanta.view* tag:

XML

```xml
<service id="pagerfanta.view.default" class="Pagerfanta\View\DefaultView" public="false">
    <tag name="pagerfanta.view" alias="default" />
</service>
```

YAML

```yml
services:
    pagerfanta.view.default:
        class: Pagerfanta\View\DefaultView
        public: false
        tags: [{ name: pagerfanta.view, alias: default }]
```

Customize buttons labels
------------------------

You can costomize label with some HTML code if needed.

In config.yml

```yml
twig:
    globals:
        pagerfanta_opts:
            prev_message: "<samp class='sr-only'>Prev page</samp></i>"
            next_message: "<samp class='sr-only'>Next page</samp></i>"
            dots_message: "&middot;&middot;&middot;"
```

Reusing Options
---------------

Sometimes you want to reuse options of a view in your project, and you don't
want to write them all the times you render a view, or you can have different
configurations for a view and you want to save them in a place to be able to
change them easily.

For this you have to define views with the special view *OptionableView*:

```yml
services:
    pagerfanta.view.my_view_1:
        class: Pagerfanta\View\OptionableView
        arguments:
            - @pagerfanta.view.default
            - { proximity: 2, prev_message: Anterior, next_message: Siguiente }
        public: false
        tags: [{ name: pagerfanta.view, alias: my_view_1 }]
    pagerfanta.view.my_view_2:
        class: Pagerfanta\View\OptionableView
        arguments:
            - @pagerfanta.view.default
            - { proximity: 5 }
        public: false
        tags: [{ name: pagerfanta.view, alias: my_view_2 }]
```

And using then:

```twig
{{ pagerfanta(pagerfanta, 'my_view_1') }}
{{ pagerfanta(pagerfanta, 'my_view_2') }}
```

The easiest way to render pagerfantas (or paginators!) ;)

Configuration
-------------

It's possible to configure the default view for all rendering in your
configuration file:

```yml
white_october_pagerfanta:
    default_view: my_view_1
```

Basic CSS for the default view
------------------------------

The bundles comes with a basic css for the default view to be able to use a
good paginator faster. Of course you can change it, use another one or
create your own view.

```html
<link rel="stylesheet" href="{{ asset('bundles/whiteoctoberpagerfanta/css/pagerfantaDefault.css') }}" type="text/css" media="all" />
```

More information
----------------

For more advanced documentation, check the [Pagerfanta documentation](https://github.com/whiteoctober/Pagerfanta/blob/master/README.md).

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
