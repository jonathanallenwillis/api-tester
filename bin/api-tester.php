#!/usr/bin/env php
<?php
/**
 * Created by PhpStorm.
 * User: Jonathan Willis
 * Date: 10/09/15
 * Time: 5:11 AM
 */

require __DIR__ . '/../vendor/autoload.php';

use Quickmire\ApiTester\Console\Command\ApiTesterCommand;
use Symfony\Component\Console\Application;

$app = new Application('API Tester', '@package_version@');
$app->add(new ApiTesterCommand());
$app->run();
