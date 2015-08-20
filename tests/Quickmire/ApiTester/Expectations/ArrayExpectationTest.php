<?php namespace Quickmire\ApiTester\Expectations;

/**
 * Created by PhpStorm.
 * User: Jonathan Willis
 * Date: 19/08/15
 * Time: 6:00 AM
 */



class ArrayExpectationTest
    extends \PHPUnit_Framework_TestCase
{
    public function providePassingQuantifiers()
    {
        return array(
            array( '1', 1),
            array( '2+', 2),
            array( '3-', 3),
            array( '2-', 1),
            array( '10-', 9),
            array( '111-112', 111),
            array( '111-112', 112),
            array( '1-1000', 999),
        );
    }

    /**
     * @test
     * @dataProvider providePassingQuantifiers
     */
    public function can_assert_quantifiers($quantifier, $n)
    {
        $exp = new ArrayExpectation(array(array(), $quantifier));
        $this->assertTrue($exp->assertQuantifier($n));
    }


    public function provideFailingQuantifiers()
    {
        return array(
            array( '1', 2),
            array( '2+', 1),
            array( '3-', 4),
            array( '2-', 99),
            array( '10-', 11),
            array( '111-112', 110),
            array( '111-112', 113),
            array( '1-1000', 0),
            array( '1-1000', 10000),
        );
    }

    /**
     * @test
     * @dataProvider provideFailingQuantifiers
     */
    public function can_assert_failing_quantifiers($quantifier, $n)
    {
        $exp = new ArrayExpectation(array(array(), $quantifier));
        $this->assertFalse($exp->assertQuantifier($n));
    }

}