<?php
/**
 * Created by PhpStorm.
 * User: Jonathan Willis
 * Date: 05/09/15
 * Time: 9:51 AM
 */

namespace Quickmire\ApiTester;


use Quickmire\ApiTester\FetcherResolvers\MapResolver;
use Quickmire\ApiTester\Fetchers\FileFetcher;
use Symfony\Component\Config\Util\XmlUtils;
use Symfony\Component\Yaml\Yaml;

class ResourceLoaderTest
    extends \PHPUnit_Framework_TestCase
{
    protected $data = array(
                        'a' => 1,
                        'b' => 'string',
                        'c' => array(
                            'd' => null
                            )
                        );
    public function setUp()
    {

    }
    protected function createFixture($filename, $data, $type='txt')
    {
        $dir = __DIR__ . '/../../fixtures';
        $path = "{$dir}/{$filename}";

        switch(strtolower($type)) {
            case 'yml':     $content = Yaml::dump($data); break;
            case 'json':    $content = json_encode($data, JSON_PRETTY_PRINT); break;
            case 'txt':     $content = $data; break;
            default:        throw new \Exception('Testing error, unknown type');
        }

        file_put_contents($path, $content);
        return realpath($path);
    }

    /**
     * @test
     */
    public function can_load_a_file()
    {
        $resolver = new MapResolver(array('file' => new FileFetcher()));
        $expected = 'asdfasdf';
        $path = $this->createFixture('test.txt', $expected);
        $l = new ResourceLoader($resolver);
        $actual = $l->load($path);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function can_load_a_json_file()
    {
        $resolver = new MapResolver(array('file' => new FileFetcher()));
        $expected = $this->data;
        $path = $this->createFixture('test.json', $expected, 'json');
        $l = new ResourceLoader($resolver);
        $actual = $l->load($path);
        $this->assertEquals($expected, $actual);

    }

    /**
     * @test
     */
    public function can_load_a_yaml_file()
    {
        $resolver = new MapResolver(array('file' => new FileFetcher()));
        $expected = $this->data;
        $path = $this->createFixture('test.yml', $expected, 'yml');
        $l = new ResourceLoader($resolver);
        $actual = $l->load($path);
        $this->assertEquals($expected, $actual);

    }

    /**
     * @test
     */
//    public function can_load_a_http_resource()
//    {
//        $expected = $this->data;
//        $l = new ResourceLoader();
//        $actual = $l->load('http://ip-api.com/json');
//        $this->assertEquals($expected, $actual);
//
//    }


}