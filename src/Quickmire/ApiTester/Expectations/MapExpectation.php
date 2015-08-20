<?php
/**
 * Created by PhpStorm.
 * User: Jonathan Willis
 * Date: 18/08/15
 * Time: 6:52 AM
 */

namespace Quickmire\ApiTester\Expectations;


use Quickmire\ApiTester\Expectation;

class MapExpectation
    extends AbstractExpectation
{
    public function assert($data)
    {
        $this->messages = array();
        foreach( $this->definition as $field => $type ) {
            if ( isset($data[$field]) ) {
                $expectation = Expectation::resolver($type);
                if( !$expectation->assert($data[$field]) ) {
                    $this->messages = array_merge($this->messages, $expectation->getMessages());
                }
                unset($data[$field]);
            } else {
                $this->messages[] = "Missing field $field";
            }
        }
        return empty($this->messages);
    }
}