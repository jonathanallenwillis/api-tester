<?php
/**
 * Created by PhpStorm.
 * User: Jonathan Willis
 * Date: 05/09/15
 * Time: 11:19 AM
 */

namespace Quickmire\ApiTester;


interface FetcherResolverInterface
{
    /**
     * @param $uriOrPath URI or path
     * @return mixed
     */
    public function resolve($uriOrPath);
}