<?php
/**
 * Created by PhpStorm.
 * User: Jonathan Willis
 * Date: 05/09/15
 * Time: 10:42 AM
 */

namespace Quickmire\ApiTester\Fetchers;


use Quickmire\ApiTester\FetcherInterface;

class FileFetcher
    implements FetcherInterface
{
    protected $path = null;

    public function setResource($path)
    {
        $this->path = $path;
        return $this;
    }

    public function getContents()
    {
        return file_get_contents($this->path);
    }

    public function getContentType()
    {
        return pathinfo($this->path, PATHINFO_EXTENSION);
    }

    public function supports($resource)
    {
        $parts = parse_url($resource);

        $scheme = isset($parts['scheme']) ? $parts['scheme'] : 'file';

        return $scheme==='file';
    }
}