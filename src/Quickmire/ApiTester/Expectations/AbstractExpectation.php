<?php
/**
 * Created by PhpStorm.
 * User: Jonathan Willis
 * Date: 18/08/15
 * Time: 6:32 AM
 */

namespace Quickmire\ApiTester\Expectations;


use Quickmire\ApiTester\ExpectationInterface;

abstract class AbstractExpectation
    implements ExpectationInterface
{
    protected $messages;
    protected $definition;
    public function __construct($definition)
    {
        $this->definition = $definition;
        $this->messages = array();
    }

    public function getMessages()
    {
        return $this->messages;
    }
}