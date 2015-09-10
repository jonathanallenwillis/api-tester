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
            array('1', 1),
            array('2+', 2),
            array('3-', 3),
            array('2-', 1),
            array('10-', 9),
            array('111-112', 111),
            array('111-112', 112),
            array('1-1000', 999),
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
            array('1', 2),
            array('2+', 1),
            array('3-', 4),
            array('2-', 99),
            array('10-', 11),
            array('111-112', 110),
            array('111-112', 113),
            array('1-1000', 0),
            array('1-1000', 10000),
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

    /**
     * @test
     */
    public function can_get_list_of_all_assert_error_messages()
    {
        $definition = array('name'=>'string', 'dob'=>'/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/');
        $data = array(
                    array('name'=>'ben', 'dob'=>'d1706-01-17'),
                    array('name'=>'leonardo', 'dob'=>'d1452-04-15'));
        $exp = new ArrayExpectation(array($definition, '3+'));
        $this->assertFalse($exp->assert($data));
        $this->assertEquals('Failed asserting data [d1706-01-17] matches regex [/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/].Failed asserting data [d1452-04-15] matches regex [/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/].Failed asserting quantifier [3+] with actual value [2].', implode('',$exp->getMessages()));
    }

    /**
     * @test
     */
    public function returns_false_if_bad_quantifier()
    {
        $exp = new ArrayExpectation(array(array(), '-1-1-1'));
        $this->assertFalse($exp->assertQuantifier(123));
        $this->assertEquals('Invalid quantifier [-1-1-1].', implode('', $exp->getMessages()));

    }

}