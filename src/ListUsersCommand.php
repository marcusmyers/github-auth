<?php namespace MarkMyers;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListUsersCommand extends Command {

  public function configure()
  {
    $this->setName('list-users')
         ->setDescription('List GitHub users already added to `~/.ssh/authorized_keys`');
  }

  public function execute(InputInterface $input, OutputInterface $output)
  {
    if (!file_exists(self::getKeysFile()) ) {
      $output->writeln("<error>You don't have any users in your authorized_keys file. Run `gh-auth add` to add a user.</error>");
      $this->clean_exit(1);
    }

    $arrFile = file(self::getKeysFile());
    $arrUsers = $this->getUsers($arrFile);

    foreach($arrUsers as $user) {
      $output->writeln("<info>* ".$user."</info>");
    }
  }

  private function getUsers($file)
  {
    $users = [];
    foreach($file as $line) {
      list($prefix, $key, $email) = explode(' ', $line);
      list($user, $domain) = explode('@', $email);
      $users[] = $user;
    }

    return $users;
  }

  private function clean_exit($status_code)
  {
    exit($status_code);
  }
}
