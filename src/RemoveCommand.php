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
    $user = $input->getArgument('user');
  }

  private function remove_from_file($user, $file)
  {
    $allUsers = file($file, FILE_IGNORE_NEW_LINES);

  }

  private function write_to_file($keys, $file, $user)
  {
    if (!file_exists($file)) {
      touch($file);
    }
    $fh = fopen($file, 'a');
    foreach($keys as $key) {
      $gh = $key->key . " " . $user;
      if(!fwrite($fh, $gh)) {
        throw new RuntimeException("Not able to write to the file.");
      }
    }
  }
}
