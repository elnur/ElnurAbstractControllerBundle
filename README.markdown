ElnurAbstractControllerBundle
=============================

So, you decided to [define your controllers as services][services]? That's
great! But isn't injecting the same basic services into each controllers tedious
and boring? Not anymore!

Installation
------------

1.  Add this to the `deps` file:

        [ElnurAbstractControllerBundle]
            git=http://github.com/elnur/ElnurAbstractControllerBundle.git
            target=/bundles/Elnur/AbstractControllerBundle

    And run `bin/vendors install`.

2.  Register the `Elnur` namespace in the `app/autoload.php` file:

        $loader->registerNamespaces(array(
            // ...
            'Elnur'            => __DIR__.'/../vendor/bundles',
        ));

3.  Register the bundle in the `app/AppKernel.php` file:

        public function registerBundles()
        {
            $bundles = array(
                // ...
                new Elnur\AbstractControllerBundle\ElnurAbstractControllerBundle(),
            );
        }

Usage
-----

Make your controller extend the `AbstractController` class:

    <?php
    namespace Acme\Bundle\AppBundle\Controller;

    use Elnur\AbstractControllerBundle\AbstractController;

    class UserController extends AbstractController
    {
        // ...
    }

And define `elnur.controller.abstract` as the [parent service][]:

    services:
        user_controller:
            class: Acme\Bundle\AppBundle\Controller\UserController
            parent: elnur.controller.abstract

License
-------

This bundle is under the MIT license. See the complete license in the bundle:

    Resources/meta/LICENSE

[services]: http://symfony.com/doc/current/cookbook/controller/service.html
[parent service]: http://symfony.com/doc/current/cookbook/service_container/parentservices.html
