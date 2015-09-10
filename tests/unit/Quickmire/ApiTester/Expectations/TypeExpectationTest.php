<?php
/**
 * Created by PhpStorm.
 * User: Jonathan Willis
 * Date: 19/08/15
 * Time: 5:58 AM
 */

namespace Quickmire\ApiTester\Expectations;


use Quickmire\ApiTester\Expectation;

class TypeExpectationTest
    extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function can_assert_different_types()
    {
        $types = array(
            'object'    => new \stdClass(),
            'string'    => 'This is a string',
            'boolean'   => true,
            'integer'   => 123,
            'double'    => 3.4,
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

}