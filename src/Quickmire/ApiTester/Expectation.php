<?php namespace Quickmire\ApiTester;
use Quickmire\ApiTester\Expectations\ArrayExpectation;
use Quickmire\ApiTester\Expectations\MapExpectation;
use Quickmire\ApiTester\Expectations\RegexExpectation;
use Quickmire\ApiTester\Expectations\TypeExpectation;

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
        $this->expectation = self::resolver($definition);
    }

    public function assert($data)
    {
        return $this->expectation->assert($data);
    }

    public function getMessages()
    {
        return $this->expectation->getMessages();
    }

    static public function resolver($definition)
    {
        if ( self::isMap($definition) ) {
            return new MapExpectation($definition);
        } elseif( self::isArray($definition) ) {
            return new ArrayExpectation($definition);
        } elseif( self::isRegex($definition) ) {
            return new RegexExpectation($definition);
        }
        return new TypeExpectation($definition);
    }

    static protected function isMap($definition)
    {
        return is_array($definition)
                && array_keys($definition)!==range(0, count($definition)-1);
    }

    public static function isArray($definition)
    {
        return is_array($definition)
                && array_keys($definition)===range(0, count($definition)-1);
    }
    static protected function isRegex($str)
    {
        // @TODO find better way
        return $str[0]===$str[strlen($str)-1];
    }
}