<?php
/**
 * Created by PhpStorm.
 * User: Jonathan Willis
 * Date: 07/09/15
 * Time: 9:11 AM
 */

namespace Quickmire\ApiTester;


class ExpectationTesterTest
    extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function can_test()
    {
        $definitions = array(
            'type'          => 'json',
            'expectations'  => array(
                array(
                    'uri'       => '/date.json',
                    'expected'  => array( 'date' => '/[0-9]{4}-[0-9]{2}-[0-9]{2}/' )
                )
            )
        );
        $responses = array(
            'date.json' => array( 'date' => '2006-12-26' ),
        );
        $path = $this->createFixture($definitions, $responses);

        $tester = new ExpectationTester($path);
        $this->assertTrue($tester->test());
    }

    protected function createFixture(array $definitions, array $responses)
    {
        $dir = __DIR__ . '/../../fixtures';
        if ( !file_exists($dir) && !mkdir($dir, true) ) {
            throw new Exception('Failed creating fixtures directory, please create it.');
        }
        $dir = realpath($dir);
        $definitions['base_uri'] = $dir;

        foreach( $responses as $filename=>$response ) {
            $path = "{$dir}/{$filename}";
            file_put_contents($path, json_encode($response, JSON_PRETTY_PRINT));
        }

        $path = "{$dir}/definition.json";
        $content = json_encode($definitions, JSON_PRETTY_PRINT);
        file_put_contents($path, $content);

        return $path;
    }
}