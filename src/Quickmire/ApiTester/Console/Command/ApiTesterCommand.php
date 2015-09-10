<?php
/**
 * Created by PhpStorm.
 * User: Jonathan Willis
 * Date: 10/09/15
 * Time: 5:05 AM
 */

namespace Quickmire\ApiTester\Console\Command;

use Quickmire\ApiTester\ExpectationTester;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class ApiTesterCommand
    extends Command
{
    const NAME = 'api:test';

    protected function configure()
    {
        $this
            ->setName(self::NAME)
            ->setDescription('Test an API given a config')
            ->addArgument(
                'source',
                InputArgument::REQUIRED,
                'source config to use'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $source = $input->getArgument('source');
        if( !file_exists($source) ) {
            throw new FileNotFoundException("File does not exist: \n{$source}\n");
        }
        $tester = new ExpectationTester($source);
        $tester->test();
        // Silence on success.
    }

}