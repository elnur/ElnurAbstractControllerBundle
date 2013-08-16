<?php
/*
 * Copyright (c) 2011-2013 Elnur Abdurrakhimov
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */
namespace Elnur\ControllerBundle\Tests;

use ReflectionMethod;
use Mockery as m;
use Elnur\AbstractControllerBundle\AbstractController;

class ControllerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AbstractController
     */
    private $controller;

    protected function tearDown()
    {
        m::close();
    }

    protected function setUp()
    {
        $this->controller = m::mock('Elnur\AbstractControllerBundle\AbstractController[]');
    }

    public function testGetUser()
    {
        $securityContext = m::mock('Symfony\Component\Security\Core\SecurityContextInterface');
        $token           = m::mock('Symfony\Component\Security\Core\Authentication\Token\TokenInterface');
        $user            = m::mock('Symfony\Component\Security\Core\User\UserInterface');

        $this->controller->setSecurityContext($securityContext);

        $securityContext
            ->shouldReceive('getToken')
            ->once()
            ->withNoArgs()
            ->andReturn($token)
        ;

        $token
            ->shouldReceive('getUser')
            ->once()
            ->withNoArgs()
            ->andReturn($user)
        ;

        $method = new ReflectionMethod(
            'Elnur\AbstractControllerBundle\AbstractController',
            'getUser'
        );
        $method->setAccessible(true);

        $result = $method->invoke($this->controller);
        $this->assertEquals($user, $result);
    }

    public function testAddFlash()
    {
        $session  = m::mock('Symfony\Component\HttpFoundation\Session\SessionInterface');
        $flashBag = m::mock('Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface');

        $type    = 'type';
        $message = 'message';

        $this->controller->setSession($session);

        $session
            ->shouldReceive('getFlashBag')
            ->once()
            ->withNoArgs()
            ->andReturn($flashBag)
        ;

        $flashBag
            ->shouldReceive('add')
            ->once()
            ->with($type, $message)
        ;

        $method = new ReflectionMethod(
            'Elnur\AbstractControllerBundle\AbstractController',
            'addFlash'
        );
        $method->setAccessible(true);

        $method->invoke($this->controller, $type, $message);
    }
}
