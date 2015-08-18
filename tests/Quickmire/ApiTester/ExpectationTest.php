<?php namespace Quickmire\ApiTester;
/**
 * Created by PhpStorm.
 * User: Jonathan Willis
 * Date: 18/08/15
 * Time: 5:43 AM
 */



class ExpectationTest
    extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function me()
    {
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function can_assert_simple_expectations()
    {
        $types = array(
            'string'    => 'This is a string',
            'boolean'   => true,
            'integer'   => 123,
            'double'    => 3.4,
            'object'    => new \stdClass(),
            'array'     => array( 1, 2, '3'),
            'NULL'      => null
        );
        foreach( $types as $type=>$example ) {
            $exp = new Expectation($type);
            $this->assertTrue($exp->assert($example));
            foreach ( $types as $type2=>$badExample ) {
                if( $type!==$type2 ) {
                    $this->assertFalse($exp->assert($badExample));
                }
            }
        }
    }

    /**
     * @test
     */
    public function can_assert_regex_expectations()
    {
        $expectations = array(
            '/^[\w._%+-]+@[\w.-]+\.[A-Za-z]{2,4}$/' => 'jo@usa.net',
            '/[0-9]/'   => 7,
            '/[0-9]*/'   => '',
            '/[0-9]*/'   => '4',
            '/[0-9]*/'   => '432',
        );
        foreach ( $expectations as $regex=>$example ) {
            $exp = new Expectation($regex);
            $this->assertTrue($exp->assert($example));
        }
    }

    /**
     * @test
     */
    public function can_assert_dict_expectations()
    {
        $expectation = array(
            'name'      => 'string',
            'address'   => array(
                'civic#'=> 'integer',
                'street'=> 'string',
            ),
            'is_male'   => 'boolean',
            'birthdate' => '~[0-9]{4}/[0-9]{2}/[0-9]{2}~'
        );
        $data = array(
            'name'      => 'jo blo',
            'address'   => array(
                'civic#'=> 123,
                'street'=> 'main',
            ),
            'is_male'   => true,
            'birthdate' => '1999/12/21'
        );
        $exp = new Expectation($expectation);
        $this->assertTrue($exp->assert($data));
    }


}