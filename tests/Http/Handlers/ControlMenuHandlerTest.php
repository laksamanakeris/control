<?php namespace Orchestra\Control\Http\Handlers\TestCase;

use Mockery as m;
use Orchestra\Widget\Handlers\Menu;
use Orchestra\Foundation\Support\MenuHandler;
use Illuminate\Contracts\Foundation\Application;
use Orchestra\Control\Http\Handlers\ControlMenuHandler;

class ControlMenuHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testItIsInitializable()
    {
        $app  = m::mock(Application::class);
        $menu = m::mock(Menu::class);

        $app->shouldReceive('make')->once()->with('orchestra.platform.menu')->andReturn($menu);

        $stub = new ControlMenuHandler($app);

        $this->assertInstanceOf(ControlMenuHandler::class, $stub);
        $this->assertInstanceOf(MenuHandler::class, $stub);
    }

    public function testItShouldBeChildOfExtensionGivenExtensionIsAvailable()
    {
        $app  = m::mock(Application::class);
        $menu = m::mock(Menu::class);

        $app->shouldReceive('make')->once()->with('orchestra.platform.menu')->andReturn($menu);
        $menu->shouldReceive('has')->once()->with('extensions')->andReturn(true);

        $stub = new ControlMenuHandler($app);

        $this->assertEquals('>:extensions', $stub->getPositionAttribute());
    }

    public function testItShouldNextToHomeGivenExtensionIsntAvailable()
    {
        $app  = m::mock(Application::class);
        $menu = m::mock(Menu::class);

        $app->shouldReceive('make')->once()->with('orchestra.platform.menu')->andReturn($menu);
        $menu->shouldReceive('has')->once()->with('extensions')->andReturn(false);

        $stub = new ControlMenuHandler($app);

        $this->assertEquals('>:home', $stub->getPositionAttribute());
    }
}
