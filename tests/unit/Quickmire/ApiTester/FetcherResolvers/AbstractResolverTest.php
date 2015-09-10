<?php
/**
 * Created by PhpStorm.
 * User: Jonathan Willis
 * Date: 05/09/15
 * Time: 11:31 AM
 */

namespace Quickmire\ApiTester\FetcherResolvers;


class AbstractResolverTest
    extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function can_guess_scheme_on_relative_path()
    {
        $r = $this->getMockForAbstractClass('Quickmire\ApiTester\FetcherResolvers\AbstractResolver');
        $this->assertEquals('file', $r->guessScheme('test.txt'));
    }
    /**
     * @test
     */
    public function can_guess_scheme_on_absolute_path()
    {
        $r = $this->getMockForAbstractClass('Quickmire\ApiTester\FetcherResolvers\AbstractResolver');
        $this->assertEquals('file', $r->guessScheme('/tmp/test/test.txt'));
    }
    /**
     * @test
     */
    public function can_guess_scheme_on_file_uri()
    {
        $r = $this->getMockForAbstractClass('Quickmire\ApiTester\FetcherResolvers\AbstractResolver');
        $this->assertEquals('file', $r->guessScheme('file:///tmp/test/test.txt'));
    }
    /**
     * @test
     */
    public function can_guess_scheme_on_http_uri()
    {
        $r = $this->getMockForAbstractClass('Quickmire\ApiTester\FetcherResolvers\AbstractResolver');
        $this->assertEquals('http', $r->guessScheme('http://example.com/test/test.txt'));
    }
}