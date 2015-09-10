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
//        $definitions = array(
//            'type'          => 'json',
//            'expectations'  => array(
//                array(
//                    'uri'       => '/date.json',
//                    'expected'  => array( 'date' => '/[0-9]{4}-[0-9]{2}-[0-9]{2}/' )
//                )
//            )
//        );
//        $responses = array(
//            'date.json' => array( 'date' => '2006-12-26' ),
//        );
//        $path = $this->createFixture($definitions, $responses);

        $path = __DIR__ . '/../../fixtures/definition.json';
        $tester = new ExpectationTester($path);
        $this->assertTrue($tester->test());
    }

    /**
     * @test
     */
    public function throws_on_type_mismatch()
    {
//        $definitions = array(
//            'type'          => 'yml',
//            'expectations'  => array(
//                array(
//                    'uri'       => '/date.json',
//                    'expected'  => array( 'date' => '/[0-9]{4}-[0-9]{2}-[0-9]{2}/' )
//                )
//            )
//        );
//        $responses = array(
//            'date.json' => array( 'date' => '2006-12-26' ),
//        );
//        $path = $this->createFixture($definitions, $responses, 'type_mismatch');
        $path = __DIR__ . '/../../fixtures/definition_type_mismatch.json';
        $tester = new ExpectationTester($path);
        try {
            $tester->test();
            $this->fail('Failed asserting FailedExpectationException');
        } catch (FailedExpectationException $e) {
            $this->assertRegExp('/Type mismatch for .*date\.json\. Got \[json\] but expected \[yml\]/', $e->getMessage());
        }

    }

    /**
     * @test
     */
    public function throws_failedexpectation_when_testing_invalid_data()
    {
        $path = __DIR__ . '/../../fixtures/definition_invalid.json';
        $tester = new ExpectationTester($path);
        try {
            $tester->test();
            $this->fail('Failed asserting invalid data throws FailedExpectationException');
        } catch (FailedExpectationException $e) {
            $this->assertEquals('Failed asserting data [200-12-26] matches regex [/[0-9]{4}-[0-9]{2}-[0-9]{2}/].', $e->getMessage());
        }
    }

    protected function createFixture(array $definitions, array $responses, $suffix=null)
    {
        $suffix = $suffix===null ? '' : "_{$suffix}";
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

        $path = "{$dir}/definition{$suffix}.json";
        $content = json_encode($definitions, JSON_PRETTY_PRINT);
        file_put_contents($path, $content);

        return $path;
    }
}