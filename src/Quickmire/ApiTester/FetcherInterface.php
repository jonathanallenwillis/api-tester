<?php
/**
 * Created by PhpStorm.
 * User: Jonathan Willis
 * Date: 05/09/15
 * Time: 10:42 AM
 */

namespace Quickmire\ApiTester;


interface FetcherInterface 
{
    public function setResource($resource);
    public function getContents();
    public function getContentType();
    public function supports($resource);
}