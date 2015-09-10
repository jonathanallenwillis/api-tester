<?php
/**
 * Created by PhpStorm.
 * User: Jonathan Willis
 * Date: 10/09/15
 * Time: 2:47 PM
 */

class BuildTest
    extends \PHPUnit_Framework_TestCase
{
    protected $phar;
    protected $cmd;

    public function setUp()
    {
        $this->phar = realpath(__DIR__ . '/../../build/api-tester.phar');
        $this->cmd = "/usr/bin/php {$this->phar}";
    }
    /**
     * @test
     */
    public function it_is_built()
    {
        $this->assertTrue(file_exists($this->phar));
    }

    /**
     * @test
     */
    public function is_silent_on_success()
    {
        $source = realpath(__DIR__ . '/../unit/fixtures/definition.json');
//        list($output, $code) = $this->runCommand('ls -lat');
        list($output, $code) = $this->runCommand($this->cmd, array( 'api:test' => $source ));
        $this->assertEquals('', $output);
        $this->assertEquals(0, $code);
    }

    protected function runCommand($cmd, array $args=array())
    {
        $argStr = '';
        foreach($args as $k=>$v ) {
            $argStr .= "$k $v ";
        }

        $command = new \mikehaertl\shellcommand\Command("{$cmd} {$argStr}");
        if( $command->execute() ) {
            $output = $command->getOutput();
        } else {
            $output = $command->getError();
        }
        return array($output, $command->getExitCode());
//        exec("{$cmd} {$argStr}", $output, $code);
//        $output = system("{$cmd} {$argStr} 2>&1 && echo good ", $code);
//        return array(implode("\n", $output), $code);
    }
}