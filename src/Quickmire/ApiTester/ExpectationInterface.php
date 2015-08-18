<?php
/**
 * Created by PhpStorm.
 * User: Jonathan Willis
 * Date: 18/08/15
 * Time: 6:24 AM
 */

namespace Quickmire\ApiTester;


interface ExpectationInterface 
{
    public function assert($data);
}