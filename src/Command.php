<?php namespace MarkMyers;

use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Command extends SymfonyCommand {

  const DEFAULT_PATH = "/.ssh/authorized_keys";
  const DEFAULT_HOSTNAME = "https://api.github.com";

  public function __construct()
  {
    parent::__construct();
  }

  public static function getKeysFile()
  {
    return getenv('HOME').self::DEFAULT_PATH;
  }

  protected function getKeysCount()
  {
    $count = 0;
    $fh = fopen(self::getKeysFile(), 'r');
    if($fh) {
      while(($buffer = fgets($fh, 2)) !== false){
        $count++;
      }
    }
    return $count;
  }
}
