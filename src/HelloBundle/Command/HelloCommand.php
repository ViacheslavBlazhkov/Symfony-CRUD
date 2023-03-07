<?php
namespace App\HelloBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HelloCommand extends Command {
    protected static $defaultName = 'hello';

    protected function configure() {
        $this
            ->setDescription('Say hello')
            ->setHelp('This command says hello');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Hello!');

        return Command::SUCCESS;
    }
}