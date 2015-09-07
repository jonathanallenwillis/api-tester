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
    protected $definitions;
    protected $baseOptions;

    public function __construct(array $definitions)
    {
        $this->validate($definitions);

        $this->definitions = $definitions;

        $this->baseOptions = $this->parseBaseOptions($definitions);

    }

    public function getExpectations()
    {
        $self = $this;
        $baseOptions = $this->baseOptions;
        return array_map(function($expectation) use($baseOptions) {
            if( !isset($expectation['uri']) ) {
                throw new \Exception('Missing field uri!');
            }
            if( null===parse_url($expectation['uri'], PHP_URL_SCHEME) ) {
                $uri = $baseOptions['base_uri'] . $expectation['uri'];
            } else {
                $uri = $expectation['uri'];
            }

            if ( isset($expectation['type']) ) {
                $type = $expectation['type'];
            } else {
                if ( isset($baseOptions['type']) ) $type = $baseOptions['type'];
                else throw new \Exception('Missing type field.');
            }

            if ( !isset($expectation['expected']) ) throw new \Exception('Missing expected field.');

            return array(
                'uri'       => $uri,
                'type'      => $type,
                'expected'  => $expectation['expected']
            );
        }, $this->definitions['expectations']);
    }

    protected function parseBaseOptions($definition)
    {
        return $this->collectFields($definition, array('base_uri'=>'', 'type'=>null));
    }

    protected function collectFields(array $data, $fields)
    {
        $subset = array();
        foreach( $fields as $fieldName=>$defaultValue ) {
            if( isset($data[$fieldName]) ) {
                $subset[$fieldName] = $data[$fieldName];
            } else {
                if( null!==$defaultValue ) {
                    $subset[$fieldName] = $defaultValue;
                }
            }
        }
        return $subset;
    }

    protected function validate(array $definitions)
    {
        if( !isset($definitions['expectations']) ) {
            throw new \Exception('Missing expectations field.');
        }
    }


}