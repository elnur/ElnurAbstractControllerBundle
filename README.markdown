ElnurAbstractControllerBundle
=============================

So, you decided to [define your controllers as services][services]? That's
great! But isn't injecting the same basic services into each controllers tedious
and boring? Not anymore!

The abstract controller of this bundle is automatically injected with the
following commonly used services:

  * `form.factory`,
  * `router`,
  * `translator`,
  * `security.context`,
  * `session`, and
  * `templating`.

It also provides a couple of helper methods:

  * `getUser()` — to get the currently logged in user;
  * `addFlash($type, $message)` — to add a flash message to the session.

Installation
------------

1.  Add this to `composer.json`:

        {
            "require": {
                "elnur/abstract-controller-bundle": "dev-master"
            }
        }

    And run:

        composer update elnur/abstract-controller-bundle

2.  Enable the bundle in `app/AppKernel.php`:

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
