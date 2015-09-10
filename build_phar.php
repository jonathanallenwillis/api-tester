<?php
/**
 * Created by PhpStorm.
 * User: Jonathan Willis
 * Date: 10/09/15
 * Time: 9:09 AM
 */

//$buildname = __DIR__ . './build/api-tester.phar';
$buildname = './api-tester.phar';
$phar = new Phar(
                $buildname,
                FilesystemIterator::CURRENT_AS_FILEINFO
                | FilesystemIterator::KEY_AS_FILENAME,
                'api-tester.phar');

$phar->startBuffering();
$phar->setStub('<?php Phar::mapPhar(); include "phar://api-tester.phar/console.php"; __HALT_COMPILER(); ?>');
//$phar['console.php'] = file_get_contents('console.php');
$phar->addFromString('console.php', file_get_contents('console.php'));
$phar->buildFromDirectory('src/');
$phar->buildFromDirectory('vendor/');
$phar->stopBuffering();