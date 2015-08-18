<?php
/**
 * Created by PhpStorm.
 * User: Jonathan Willis
 * Date: 18/08/15
 * Time: 6:52 AM
 */

namespace Quickmire\ApiTester\Expectations;


class MapExpectation
    extends AbstractExpectation
{
    public function assert($data)
    {
        foreach( $this->definition as $field => $type ) {
            if ( isset($data[$field]) ) {
                if ( is_array($type) ) {

                } else {
                    if( !Expectation::resolver($type)->assert($data[$field]) ) {
                        $messages[] = "Field $field did not pass expectation $type with value [{$data[$field]}]";
                    }
                }
            } else {
                $messages[] = 'Missing field $field';
            }
        }
    }
}