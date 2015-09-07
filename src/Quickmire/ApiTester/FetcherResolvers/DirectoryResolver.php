<?php
/**
 * Created by PhpStorm.
 * User: Jonathan Willis
 * Date: 06/09/15
 * Time: 1:41 PM
 */

namespace Quickmire\ApiTester\FetcherResolvers;


use Quickmire\ApiTester\FetcherResolverInterface;

class DirectoryResolver
    implements FetcherResolverInterface
{
    protected $directories;
    protected $fetchers;

    public function __construct(array $directories = null)
    {
        $this->directories = null===$directories
                                ? array('Quickmire\\ApiTester\\Fetchers' => __DIR__ . '/../Fetchers')
                                : $directories;
        $this->fetchers = null;
    }

    public function resolve($resource)
    {
        foreach( $this->getFetchers() as $fetcher ) {
            if( $fetcher->supports($resource) ) {
                return $fetcher;
            }
        }
        return null;
    }

    protected function getFetchers()
    {
        if ( null===$this->fetchers ) {
            $this->fetchers = array();
            foreach ($this->directories as $maybeNamespace => $directory) {
                if (file_exists($directory)) {
                    foreach (glob(realpath($directory) . '/' . '*Fetcher.php') as $filename) {
                        $namespace = is_int($maybeNamespace)
                            ? $this->getNamespace($filename)
                            : $maybeNamespace;
                        require_once $filename;
                        $className = $namespace . '\\' . pathinfo($filename, PATHINFO_FILENAME);
                        $this->fetchers[] = new $className();
                    }
                }
            }
        }
        return $this->fetchers;
    }

    protected function getNamespace($filename)
    {
        if( preg_match('~\s*namespace\s+(.+?);$~sm', file_get_contents($filename), $ms) ) {
            return $ms[1];
        }
        return false;
    }
}