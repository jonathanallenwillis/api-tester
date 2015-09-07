<?php
/**
 * Created by PhpStorm.
 * User: Jonathan Willis
 * Date: 07/09/15
 * Time: 5:12 AM
 */

namespace Quickmire\ApiTester\Fetchers;


use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class HttpFetcherTest
    extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function can_fetch_content_by_http()
    {
        $client = $this->createMock(array(
            array(200, array('Content-Type' => array( 'application/json; charset=utf-8' )), '{"as":"AS5645 TekSavvy Solutions, Inc.","city":"Toronto","country":"Canada","countryCode":"CA","isp":"TekSavvy Solutions","lat":43.6736,"lon":-79.4035,"org":"TekSavvy Solutions","query":"192.168.1.111","region":"ON","regionName":"Ontario","status":"success","timezone":"America/Toronto","zip":"M5R"}'),
        ));
        $uri = 'http://ip-api.com/json';
        $f = new HttpFetcher($client);

        $f->setResource($uri);
        $expected = '{"as":"AS5645 TekSavvy Solutions, Inc.","city":"Toronto","country":"Canada","countryCode":"CA","isp":"TekSavvy Solutions","lat":43.6736,"lon":-79.4035,"org":"TekSavvy Solutions","query":"192.168.1.111","region":"ON","regionName":"Ontario","status":"success","timezone":"America/Toronto","zip":"M5R"}';
        $this->assertEquals($expected, $f->getContents());
        $this->assertEquals('json', $f->getContentType());
    }

    /**
     * @test
     */
    public function can_fetch_content_by_https()
    {
        $client = $this->createMock(array(
            array(200, unserialize('a:7:{s:6:"Server";a:1:{i:0;s:5:"nginx";}s:4:"Date";a:1:{i:0;s:29:"Mon, 07 Sep 2015 10:00:54 GMT";}s:12:"Content-Type";a:1:{i:0;s:16:"application/json";}s:14:"Content-Length";a:1:{i:0;s:2:"31";}s:10:"Connection";a:1:{i:0;s:10:"keep-alive";}s:27:"Access-Control-Allow-Origin";a:1:{i:0;s:1:"*";}s:32:"Access-Control-Allow-Credentials";a:1:{i:0;s:4:"true";}}'), '{"origin": "23.91.150.41"}'),
        ));
        $uri = 'https://httpbin.org/ip';
//        $f = new HttpFetcher();
        $f = new HttpFetcher($client);

        $f->setResource($uri);
        $expected = '{"origin": "23.91.150.41"}';
        $this->assertEquals($expected, $f->getContents());
        $this->assertEquals('json', $f->getContentType());
    }

    protected function createMock(array $responseDefinitions)
    {
        $responses = array_map(function($definition) {
            return new Response($definition[0], $definition[1], $definition[2]);
        }, $responseDefinitions);
        $mock = new MockHandler($responses);
        $handler = HandlerStack::create($mock);
        return new Client(array('handler' => $handler));
    }
}