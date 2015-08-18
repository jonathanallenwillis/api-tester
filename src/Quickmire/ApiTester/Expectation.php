<?php namespace Quickmire\ApiTester;
use Quickmire\ApiTester\Expectations\MapExpectation;
use Quickmire\ApiTester\Expectations\RegexExpectation;
use Quickmire\ApiTester\Expectations\SimpleExpectation;

/**
 * Created by PhpStorm.
 * User: Jonathan Willis
 * Date: 18/08/15
 * Time: 6:00 AM
 */

class Expectation
    implements ExpectationInterface
{
    protected $definition;

    public function __construct($definition)
    {
        $this->definition = $definition;
        $this->expectation = $this->resolver($definition);
    }

    public function assert($data)
    {
        return $this->expectation->assert($data);
    }

    public function resolver($definition)
    {
        if ( $this->isMap($definition) ) {
            return new MapExpectation($definition);
        } elseif( $this->isRegex($definition) ) {
            return new RegexExpectation($definition);
        }
        return new SimpleExpectation($definition);
    }

    protected function isMap($definition)
    {
        return is_array($definition)
                && array_keys($definition)!==range(0, count($definition)-1);
    }

    protected function isRegex($str)
    {
        // @TODO find better way
        return $str[0]===$str[strlen($str)-1];
    }
}