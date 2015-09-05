<?php
/**
 * Created by PhpStorm.
 * User: Jonathan Willis
 * Date: 05/09/15
 * Time: 9:53 AM
 */

namespace Quickmire\ApiTester;


use Quickmire\ApiTester\Fetchers\FileFetcher;
use Symfony\Component\Yaml\Yaml;

class DefinitionLoader
{
    protected $fetcher = null;

    public function __construct()
    {

    }

    public function setFetcher(FetcherInterface $fetcher)
    {
        $this->fetcher = $fetcher;
        return $this;
    }

    public function getFetcher()
    {
        if( null===$this->fetcher ) {
            $this->fetcher = new FileFetcher();
        }
        return $this->fetcher;
    }

    public function load($path)
    {
        $content = $this->fetch($path);
        return $this->parse($content, $this->guessType($path));
    }

    protected function guessFetcher($uri)
    {
        $parts = parse_url($uri);

        $scheme = isset($parts['scheme']) ? $parts['scheme'] : 'file';

        switch(strtolower($scheme)) {
            case 'file':    return new FileFetcher();
            default:        throw new \Exception('Invalid fetcher scheme.');
        }
    }

    protected function fetch($uri)
    {

        return $this->guessFetcher($uri)->setResource($uri)->getContents();
    }

    protected function guessType($uri)
    {
        return $this->guessFetcher($uri)->setResource($uri)->getContentType();
    }

    protected function parse($content, $type)
    {
        switch(strtolower($type)) {
            case 'yml':     return Yaml::parse($content);
            case 'json':    return json_decode($content, true);
            case 'txt' :    return $content;
            default:        throw new \Exception('Unknown type: ' . $type);
        }
    }

}