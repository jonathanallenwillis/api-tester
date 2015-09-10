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

    /**
     * @test
     */
    public function throws_when_unresovable()
    {
        $map = array( 'file' => new FileFetcher() );
        $r = new MapResolver($map);
        try {
            $actual = $r->resolve('ftp://tmp/test.json');
        } catch(\Exception $e) {
            $this->assertEquals('Unresolvable: ftp://tmp/test.json', $e->getMessage());
        }
    }

    /**
     * @test
     */
    public function throws_when_cannot_create_fetcher()
    {
        $map = array( 'file' => '\\does\\not\\exist\\fetcher' );
        $r = new MapResolver($map);
        try {
            $actual = $r->resolve('/tmp/test.json');
        } catch(\Exception $e) {
            $this->assertEquals('Cannot create fetcher: \does\not\exist\fetcher', $e->getMessage());
        }
    }
}