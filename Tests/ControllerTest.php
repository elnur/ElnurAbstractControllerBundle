<?php
namespace Elnur\ControllerBundle\Tests;

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

        $result = $this->controller->getCurrentUser();
        $this->assertEquals($user, $result);
    }
}
