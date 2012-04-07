<?php
/*
 * Copyright (c) 2011-2012 Elnur Abdurrakhimov
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

require_once 'Mockery/Loader.php';
$loader = new \Mockery\Loader;
$loader->register();

use \Mockery as m;

class ControllerTest extends \PHPUnit_Framework_TestCase
{
    private $controller;

    protected function tearDown()
    {
        m::close();
    }

    protected function setUp()
    {
        $this->controller = m::mock('Elnur\AbstractControllerBundle\AbstractController[]');
    }

    public function testGetCurrentUser()
    {
        $securityContext = m::mock('Symfony\Component\Security\Core\SecurityContextInterface');
        $token = m::mock('Symfony\Component\Security\Core\Authentication\Token\TokenInterface');
        $user = m::mock('Symfony\Component\Security\Core\User\UserInterface');

        $this->controller->setSecurityContext($securityContext);

        $securityContext
            ->shouldReceive('getToken')
            ->once()
            ->withNoArgs()
            ->andReturn($token);

        $token
            ->shouldReceive('getUser')
            ->once()
            ->withNoArgs()
            ->andReturn($user);

        $method = new \ReflectionMethod(
            'Elnur\AbstractControllerBundle\AbstractController',
            'getCurrentUser'
        );
        $method->setAccessible(true);

        $result = $method->invoke($this->controller);
        $this->assertEquals($user, $result);
    }
}
