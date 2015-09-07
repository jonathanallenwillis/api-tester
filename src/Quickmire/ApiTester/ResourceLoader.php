<?php
/**
 * Created by PhpStorm.
 * User: Jonathan Willis
 * Date: 05/09/15
 * Time: 9:53 AM
 */

namespace Quickmire\ApiTester;


use Quickmire\ApiTester\FetcherResolvers\DirectoryResolver;
use Quickmire\ApiTester\Fetchers\FileFetcher;
use Symfony\Component\Yaml\Yaml;

class ResourceLoader
{
    protected $fetcherResolver;

    public function __construct(FetcherResolverInterface $fetcherResolver = null)
    {
        $this->fetcherResolver = null===$fetcherResolver
                                    ? new DirectoryResolver()
                                    : $fetcherResolver;
    }

    public function load($path)
    {
        $content = $this->fetch($path);
        return $this->parse($content, $this->getType($path));
    }

    public function getType($uri)
    {
        return $this->fetcherResolver->resolve($uri)->getContentType();
    }

    protected function fetch($uri)
    {

        return $this->fetcherResolver->resolve($uri)->getContents();
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