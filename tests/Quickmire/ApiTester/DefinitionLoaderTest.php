<?php
/**
 * Created by PhpStorm.
 * User: Jonathan Willis
 * Date: 05/09/15
 * Time: 9:51 AM
 */

namespace Quickmire\ApiTester;


use Symfony\Component\Config\Util\XmlUtils;
use Symfony\Component\Yaml\Yaml;

class DefinitionLoaderTest
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
    protected function createTestFile($filename, $data, $type='txt')
    {
        $dir = '.';
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
        $expected = 'asdfasdf';
        $path = $this->createTestFile('test.txt', $expected);
        $l = new DefinitionLoader();
        $actual = $l->load($path);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function can_load_a_json_file()
    {
        $expected = $this->data;
        $path = $this->createTestFile('test.json', $expected, 'json');
        $l = new DefinitionLoader();
        $actual = $l->load($path);
        $this->assertEquals($expected, $actual);

    }

    /**
     * @test
     */
    public function can_load_a_yaml_file()
    {
        $expected = $this->data;
        $path = $this->createTestFile('test.yml', $expected, 'yml');
        $l = new DefinitionLoader();
        $actual = $l->load($path);
        $this->assertEquals($expected, $actual);

    }

    /**
     * @test
     */
//    public function can_load_a_http_resource()
//    {
//        $expected = $this->data;
//        $l = new DefinitionLoader();
//        $actual = $l->load('http://ip-api.com/json');
//        $this->assertEquals($expected, $actual);
//
//    }


}