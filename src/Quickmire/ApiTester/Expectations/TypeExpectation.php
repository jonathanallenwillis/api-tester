<?php
/**
 * Created by PhpStorm.
 * User: Jonathan Willis
 * Date: 18/08/15
 * Time: 6:24 AM
 */

namespace Quickmire\ApiTester\Expectations;


class TypeExpectation
    extends AbstractExpectation
{
    public function assert($data)
    {
        $this->messages = array();
        if( gettype($data)!==$this->definition ) {
            $data = $this->dataToString($data);
            $this->messages[] = "Failed asserting data [$data] is of type [{$this->definition}].";
            return false;
        }
        return true;
    }
    protected function dataToString($data)
    {
        if( is_object($data) ) {
            return serialize($data);
        }
        return $data;
    }
}