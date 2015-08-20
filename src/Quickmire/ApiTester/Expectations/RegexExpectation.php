<?php namespace Quickmire\ApiTester\Expectations;
/**
 * Created by PhpStorm.
 * User: Jonathan Willis
 * Date: 18/08/15
 * Time: 6:31 AM
 */


class RegexExpectation
    extends AbstractExpectation
{
    public function assert($data)
    {
        $this->messages = array();
        if( preg_match($this->definition, $data)!==1 ) {
            $this->messages[] = "Failed asserting data [$data] matches regex [{$this->definition}].";
            return false;
        }
        return true;
    }
}