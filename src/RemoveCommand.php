<?php namespace MarkMyers;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RemoveCommand extends Command {

  public function configure()
  {
    $this->setName('remove')
         ->setDescription('Remove GitHub user keys from `~/.ssh/authorized_keys` for pairing')
         ->addArgument('user', InputArgument::REQUIRED, 'User keys to remove');
  }

  public function execute(InputInterface $input, OutputInterface $output)
  {

  }
}
