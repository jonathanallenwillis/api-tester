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
        return preg_match($this->definition, $data)===1;
    }
}