<?php
/**
 * Created by PhpStorm.
 * User: Jonathan Willis
 * Date: 07/09/15
 * Time: 8:40 AM
 */

namespace Quickmire\ApiTester;


class DefinitionTest
    extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function expects_a_expectations_field()
    {
        $this->assertException(new \Exception('Missing expectations field.'), function() {
            $definitions = array( );
            $d = new Definition($definitions);
        });
    }

    /**
     * @test
     */
    public function can_set_base_options()
    {
        $definitions = array(
            'type'          => 'json',
            'base_uri'      => 'http://example.com',
            'expectations'  => array(
                array(
                    'uri'       => '/date',
                    'expected'  => '/[0-9]{4}-[0-9]{2}-[0-9]{2}/'
                )
            )
        );

        $d = new Definition($definitions);
        foreach( $d->getExpectations() as $expectation ) {
            $this->assertEquals('json', $expectation['type']);
            $this->assertEquals('http://example.com/date', $expectation['uri']);
            $this->assertEquals('/[0-9]{4}-[0-9]{2}-[0-9]{2}/', $expectation['expected']);
        }
    }

    /**
     * @test
     */
    public function expects_a_uri_field_in_each_expectation()
    {
        $this->assertException(new \Exception('Missing field uri!'), function() {
            $definitions = array(
                'expectations'  => array(
                    array(
                        'expected'  => '/[0-9]{4}-[0-9]{2}-[0-9]{2}/'
                    )
                )
            );
            $d = new Definition($definitions);
            $d->getExpectations();
        });
    }

    /**
     * @test
     */
    public function expects_a_type_field_in_each_expectation()
    {
        $this->assertException(new \Exception('Missing type field.'), function() {
            $definitions = array(
                'expectations'  => array(
                    array(
                        'uri'       => 'http://www.example.com'
                    )
                )
            );
            $d = new Definition($definitions);
            $d->getExpectations();
        });
    }

    /**
     * @test
     */
    public function expects_an_expected_field_in_each_expectation()
    {
        $this->assertException(new \Exception('Missing expected field.'), function() {
            $definitions = array(
                'expectations'  => array(
                    array(
                        'uri'       => 'http://www.example.com',
                        'type'      => 'json'
                    )
                )
            );
            $d = new Definition($definitions);
            $d->getExpectations();
        });
    }

    protected function assertException($expected, $fn)
    {
        try {
            $fn();
            $this->fail('Failed asserting exception.');
        } catch(\Exception $e) {
            if ( is_string($expected) ) {
                $this->assertInstanceOf($expected, $e);
            } else {
                $this->assertEquals(get_class($expected), get_class($e));
                $this->assertEquals($expected->getMessage(), $e->getMessage());
            }
        }
    }
}