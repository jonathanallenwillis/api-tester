<?php
/**
 * Created by PhpStorm.
 * User: Jonathan Willis
 * Date: 10/09/15
 * Time: 5:33 AM
 */

namespace Quickmire\ApiTester\Console\Command;


use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class ApiTesterCommandTest
    extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function needs_source_parameter()
    {
        $commandTester= $this->createCommandTester();

        try {
            $commandTester->execute(array(
                'command'   => ApiTesterCommand::NAME,
            ));
        } catch(\RuntimeException $e) {
            $this->assertEquals('Not enough arguments.', $e->getMessage());
        }
    }

    /**
     * @test
     */
    public function is_silent_on_success()
    {
        $source = realpath(__DIR__ . '/../../../../fixtures/definition.json');
        $commandTester= $this->createCommandTester();
        $commandTester->execute(array(
            'command' => ApiTesterCommand::NAME,
            'source'    => $source,
        ));
        $this->assertEquals('', $commandTester->getDisplay());
    }

    /**
     * @test
     */
    public function has_0_return_code_on_success()
    {
        $source = realpath(__DIR__ . '/../../../../fixtures/definition.json');
        $commandTester= $this->createCommandTester();
        $commandTester->execute(array(
            'command' => ApiTesterCommand::NAME,
            'source'    => $source,
        ));
        $this->assertEquals(0, $commandTester->getStatusCode());
    }

    /**
     * @return CommandTester
     */
    protected function createCommandTester()
    {
        $app = new Application();
        $app->add(new ApiTesterCommand());
        $command = $app->find(ApiTesterCommand::NAME);
        $commandTester = new CommandTester($command);
        return $commandTester;
    }

}