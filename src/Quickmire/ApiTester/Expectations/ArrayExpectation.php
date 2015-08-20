<?php namespace Quickmire\ApiTester\Expectations;

/**
 * Created by PhpStorm.
 * User: Jonathan Willis
 * Date: 19/08/15
 * Time: 4:55 AM
 */

use Quickmire\ApiTester\Expectation;

/**
 * Class ArrayExpectation
 *
 * definition is in a format where $definition[0] is the definition and $definition[1]
 * is the quantifier (how many times in a row to expect the definition.
 *
 * Valid quantifiers:
 * <quantifier>     :=  <number>
 *                  |   <qualifier>
 *                  |   <range>
 * <qualifier>      :=  <number> '+'
 *                  |   <number> '-'
 * <range>          :=  <number> '-' <number>
 * <number> := [0-9]
 *
 * <range> is inclusive
 *
 * @package Quickmire\ApiTester\Expectations
 */

class ArrayExpectation
    extends AbstractExpectation
{
    public function assert($data)
    {
        $this->messages = array();
        $definition = $this->definition[0];
        $expectation = Expectation::resolver($definition);
        foreach( $data as $i=>$item ) {
            if( !$expectation->assert($item) ) {
                $this->messages = array_merge($this->messages, $expectation->getMessages());
            }
        }
        $this->assertQuantifier($i+1);
        return  empty($this->messages);
    }

    public function assertQuantifier($n)
    {
        $quantifier = trim($this->definition[1]);
        if( preg_match('/^(\d+)$/', $quantifier, $parts)===1 ) {
            $isValid =intval($parts[1])===$n;
        } elseif( preg_match('/^(\d+)([\-+])$/', $quantifier, $parts)===1 ) {
            $isValid =$parts[2]==='-'
                ? $n<=intval($parts[1])
                : $n>=intval($parts[1]);
        } elseif( preg_match('/^(\d+)-(\d+)$/', $quantifier, $parts)===1 ) {
        // inclusive range
            $isValid = intval($parts[1]) <= $n
                    && $n <= intval($parts[2]);
        } else {
            $this->messages[] = "Invalid quantifier [$quantifier].";
            return false;
        }

        if ( !$isValid ) $this->messages[]="Failed asserting quantifier [$quantifier] with actual value [$n].";
        return $isValid;
    }
}