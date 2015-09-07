<?php
/**
 * Created by PhpStorm.
 * User: Jonathan Willis
 * Date: 07/09/15
 * Time: 6:16 AM
 */

namespace Quickmire\ApiTester;


class Definition 
{
    protected $definition;

    public function __construct(array $definition)
    {
        if( $this->isValid($definition) ) {
            $this->definition = $definition;
        } else {
            throw new \Exception('Invalid definition');
        }

//        foreach( $definitions as $definition ) {
//            $response = $loader->load($definition['uri']);
//            $expectation = new Expectation($definition['expectation']);
//            $expectation->assert($response->getContents());
//        }
    }

    protected function isValid(array $definition)
    {
        $m = $this->validate($definition);
        return empty($m);
    }

    protected function validate(array $definition)
    {
        $messages = array();
        if( !isset($definition['expectations']) ) {
            $messages[] = 'Missing expectations field.';
        }
        return $messages;
    }

}