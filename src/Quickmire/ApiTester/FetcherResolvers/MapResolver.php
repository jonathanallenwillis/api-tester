<?php
/**
 * Created by PhpStorm.
 * User: Jonathan Willis
 * Date: 05/09/15
 * Time: 11:24 AM
 */

namespace Quickmire\ApiTester\FetcherResolvers;


use Quickmire\ApiTester\FetcherInterface;
use Quickmire\ApiTester\FetcherResolverInterface;

/**
 * Class MapResolver
 *
 * Resolves fetcher using an assoc array of type => fetcher pairs.
 * Fetchers can be string or actual objects.
 *
 * @package Quickmire\ApiTester\FetcherResolvers
 */
class MapResolver
    extends AbstractResolver
    implements FetcherResolverInterface
{
    protected $map;

    public function __construct(array $map)
    {
        $this->map = $map;
    }

    public function resolve($uriOrPath)
    {
        $scheme = $this->guessScheme($uriOrPath);

        if( isset($this->map[$scheme]) ) {
            $fetcher = $this->create($this->map[$scheme]);
            $fetcher->setResource($uriOrPath);
            return $fetcher;
        }

        throw new \Exception('Unresolvable: ' . $uriOrPath);
    }

    protected function create($fetcher)
    {
        if( is_string($fetcher) ) return new $fetcher();

        if( $fetcher instanceof FetcherInterface ) return $fetcher;

        throw new \Exception('Cannot create fetcher: ' . print_r($fetcher, true));
    }
}