<?php
/**
 * Created by PhpStorm.
 * User: Jonathan Willis
 * Date: 18/08/15
 * Time: 6:24 AM
 */

namespace Quickmire\ApiTester\Expectations;


class SimpleExpectation
    extends AbstractExpectation
{
    public function assert($data)
    {
        return gettype($data)===$this->definition;
    }
}