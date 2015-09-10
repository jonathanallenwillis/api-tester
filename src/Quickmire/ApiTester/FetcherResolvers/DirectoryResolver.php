<?php
/**
 * Created by PhpStorm.
 * User: Jonathan Willis
 * Date: 06/09/15
 * Time: 1:41 PM
 */

namespace Quickmire\ApiTester\FetcherResolvers;


use Quickmire\ApiTester\FetcherResolverInterface;
use Symfony\Component\Finder\Finder;

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
                $fetcher->setResource($resource);
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
                    $finder = new Finder();
                    $finder->files()->name('*Fetcher.php')->in($directory);
                    foreach ($finder as $file) {
                        $namespace = is_int($maybeNamespace)
                            ? $this->getNamespace($file->getContents())
                            : $maybeNamespace;
                        $className = $namespace . '\\' . pathinfo($file->getFilename(), PATHINFO_FILENAME);
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