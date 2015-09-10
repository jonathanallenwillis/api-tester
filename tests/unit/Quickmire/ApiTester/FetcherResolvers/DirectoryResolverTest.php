<?php
/**
 * Created by PhpStorm.
 * User: Jonathan Willis
 * Date: 07/09/15
 * Time: 4:34 AM
 */

namespace Quickmire\ApiTester\FetcherResolvers;


class DirectoryResolverTest
    extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function can_resolve_file_schemes()
    {
        $r = new DirectoryResolver();
        $this->assertInstanceOf(
            'Quickmire\\ApiTester\\Fetchers\\FileFetcher',
            $r->resolve('/tmp/test.json'),
            "Absolute file paths did not resolve to FileFetcher");

        $this->assertInstanceOf(
            'Quickmire\\ApiTester\\Fetchers\\FileFetcher',
            $r->resolve('./asdf/test.json'),
            "Relative file paths did not resolve to FileFetcher");

        $this->assertInstanceOf(
            'Quickmire\\ApiTester\\Fetchers\\FileFetcher',
            $r->resolve('file:///tmp/asdf/test.json'),
            "URI based file paths did not resolve to FileFetcher");
    }


    /**
     * @test
     */
    public function can_resolve_http_schemes()
    {
        $r = new DirectoryResolver();
        $this->assertInstanceOf(
            'Quickmire\\ApiTester\\Fetchers\\HttpFetcher',
            $r->resolve('http://httpbin.org/ip'),
            "http uri did not resolve to HttpFetcher");

        $this->assertInstanceOf(
            'Quickmire\\ApiTester\\Fetchers\\HttpFetcher',
            $r->resolve('https://httpbin.org/ip?param=123&param2=#afdaf'),
            "https uri with query string and hashes did not resolve to HttpFetcher");

    }
}