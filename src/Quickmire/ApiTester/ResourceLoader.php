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

class ResourceLoader
{
    protected $fetcherResolver;

    public function __construct(FetcherResolverInterface $fetcherResolver)
    {
        $this->fetcherResolver = $fetcherResolver;
    }

    public function load($path)
    {
        $content = $this->fetch($path);
        return $this->parse($content, $this->guessType($path));
    }

    protected function fetch($uri)
    {

        return $this->fetcherResolver->resolve($uri)->setResource($uri)->getContents();
    }

    protected function guessType($uri)
    {
        return $this->fetcherResolver->resolve($uri)->setResource($uri)->getContentType();
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