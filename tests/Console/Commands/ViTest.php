<?php

namespace Recca0120\Terminal\Tests\Console\Commands;

use Mockery as m;
use MockingHelpers;
use PHPUnit\Framework\TestCase;
use Recca0120\Terminal\Console\Commands\Vi;
use Symfony\Component\Console\Output\BufferedOutput;

class ViTest extends TestCase
{
    protected function tearDown()
    {
        m::close();
    }

    public function testFireRead()
    {
        $command = new Vi(
            $filesystem = m::mock('Illuminate\Filesystem\Filesystem')
        );
        MockingHelpers::mockProperty($command, 'input', $input = m::mock('Symfony\Component\Console\Input\InputInterface'));
        MockingHelpers::mockProperty($command, 'output', $output = new BufferedOutput);

        $input->shouldReceive('getArgument')->once()->with('path')->andReturn($path = 'foo');
        $input->shouldReceive('getOption')->once()->with('text')->andReturn($text = null);

        $command->setLaravel(
            $laravel = m::mock('Illuminate\Contracts\Foundation\Application')
        );
        $laravel->shouldReceive('basePath')->once()->andReturn($basePath = 'foo/');

        $filesystem->shouldReceive('get')->with($basePath.$path);

        $command->fire();
    }

    public function testFireWrite()
    {
        $command = new Vi(
            $filesystem = m::mock('Illuminate\Filesystem\Filesystem')
        );
        MockingHelpers::mockProperty($command, 'input', $input = m::mock('Symfony\Component\Console\Input\InputInterface'));
        MockingHelpers::mockProperty($command, 'output', $output = new BufferedOutput);

        $input->shouldReceive('getArgument')->once()->with('path')->andReturn($path = 'foo');
        $input->shouldReceive('getOption')->once()->with('text')->andReturn($text = 'foo');

        $command->setLaravel(
            $laravel = m::mock('Illuminate\Contracts\Foundation\Application')
        );
        $laravel->shouldReceive('basePath')->once()->andReturn($basePath = 'foo/');

        $filesystem->shouldReceive('put')->with($basePath.$path, $text);

        $command->fire();
    }
}
