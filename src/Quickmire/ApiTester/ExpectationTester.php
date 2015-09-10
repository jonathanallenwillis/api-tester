<?php
/**
 * Created by PhpStorm.
 * User: Jonathan Willis
 * Date: 07/09/15
 * Time: 7:47 AM
 */

namespace Quickmire\ApiTester;


class ExpectationTester 
{
    protected $source;

    public function __construct($source)
    {
        $this->source = $source;
    }

    public function test()
    {
        $loader = new ResourceLoader();
        $definitions = new Definition($loader->load($this->source));

        foreach( $definitions->getExpectations() as $definition ) {
            if ( null!==$definition['type'] ) {
                $actual = $loader->getType($definition['uri']);
                if( $actual!==$definition['type'] ) {
                    throw new FailedExpectationException("Type mismatch for {$definition['uri']}. Got [{$actual}] but expected [{$definition['type']}]");
                }
            }
            $expectation = new Expectation($definition['expected']);
            if( !$expectation->assert($loader->load($definition['uri'])) ) {
                throw new FailedExpectationException(implode("\n", $expectation->getMessages()));
            }
        }
        return true;
    }
}