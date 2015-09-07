<?php
/**
 * Created by PhpStorm.
 * User: Jonathan Willis
 * Date: 07/09/15
 * Time: 4:46 AM
 */

namespace Quickmire\ApiTester\Fetchers;


use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Quickmire\ApiTester\FetcherInterface;

class HttpFetcher
    implements FetcherInterface
{
    protected $uri = null;

    protected $contents = null;
    protected $contentType = null;

    protected $httpClient;

    public function __construct(ClientInterface $httpClient=null)
    {
        $this->httpClient = null===$httpClient
                                ? new Client()
                                : $httpClient;
    }

    public function setResource($uri)
    {
        if ( $uri!==$this->uri ) {
            $this->uri = $uri;
            $this->contents = null;
            $this->contentType = null;
        }
        return $this;
    }

    public function getContents()
    {
        if( null===$this->contents ) {
            $this->doCall();
        }
        return $this->contents;
    }

    public function getContentType()
    {
        if( null===$this->contentType ) {
            $this->doCall();
        }
        return $this->contentType;
    }

    public function supports($uri)
    {
        $parts = parse_url($uri);

        return isset($parts['scheme']) && ($parts['scheme']==='http' || $parts['scheme']==='https');
    }

    protected function doCall()
    {
        $response = $this->httpClient->get($this->uri);

        if ( $response->getStatusCode()!==200 ) throw new \Exception('Failed fetching ' . $this->uri);

        $this->contents = (string) $response->getBody();
        $contentType = $response->getHeader('content-type');
        if ( count($contentType)>0 ) {
            $contentType = $contentType[0];
            $contentType = explode(';', $contentType)[0];
            $parts = explode('/', $contentType);
            $this->contentType = count($parts)===1 ? $parts[0] : $parts[1];
        } else {
            // ??
        }
    }
}