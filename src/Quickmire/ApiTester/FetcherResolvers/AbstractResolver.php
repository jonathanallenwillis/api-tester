<?php
/**
 * Created by PhpStorm.
 * User: Jonathan Willis
 * Date: 05/09/15
 * Time: 11:22 AM
 */

namespace Quickmire\ApiTester\FetcherResolvers;


use Quickmire\ApiTester\FetcherResolverInterface;

abstract class AbstractResolver
    implements FetcherResolverInterface
{
    public function guessScheme($uriOrPath)
    {
        $parts = parse_url($uriOrPath);

        return isset($parts['scheme']) ? $parts['scheme'] : 'file';
    }
}