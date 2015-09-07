<?php
/**
 * Created by PhpStorm.
 * User: Jonathan Willis
 * Date: 05/09/15
 * Time: 11:43 AM
 */

namespace Quickmire\ApiTester\FetcherResolvers;


use Quickmire\ApiTester\FetcherResolverInterface;
use Quickmire\ApiTester\Fetchers\FileFetcher;

class MapResolverTest
    extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function can_resolve_using_a_map_of_strings()
    {
        $map = array( 'file' => 'Quickmire\\ApiTester\\Fetchers\\FileFetcher' );
        $r = new MapResolver($map);
        $actual = $r->resolve('file:///tmp/test.json');
        $this->assertInstanceOf('Quickmire\\ApiTester\\Fetchers\\FileFetcher', $actual);
    }
    /**
     * @test
     */
    public function can_resolve_using_a_map_of_instances()
    {
        $map = array( 'file' => new FileFetcher() );
        $r = new MapResolver($map);
        $actual = $r->resolve('file:///tmp/test.json');
        $this->assertInstanceOf('Quickmire\\ApiTester\\Fetchers\\FileFetcher', $actual);
    }

}