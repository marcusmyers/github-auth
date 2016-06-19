<?php namespace MarkMyers;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RemoveCommand extends Command {

  private $removed;

  public function __construct()
  {
    $this->removed = 0;
    parent::__construct();
  }

  public function configure()
  {
    $this->setName('remove')
         ->setDescription('Remove GitHub user keys from `~/.ssh/authorized_keys` for pairing')
         ->addArgument('user', InputArgument::REQUIRED, 'User keys to remove');
  }

  public function execute(InputInterface $input, OutputInterface $output)
  {
    $user = $input->getArgument('user');
    if ($this->remove_from_file($user, self::getKeysFile())){
      $output->writeln("<info>Removed ".$this->removed." keys from your authorized_keys file</info>");
    } else {
      $output->writeln("<error>ERROR!?!? Removing keys was unsucessful</error>");
    }
  }

  private function remove_from_file($user, $file)
  {
    $allUsers = file($file, FILE_IGNORE_NEW_LINES);
    $matches = preg_grep('/'.$user.'/', $allUsers);
    $this->removed = count($matches);
    $arrLeft = array_diff($allUsers, $matches);
    return $this->write_to_file($arrLeft, $file);
  }

  private function write_to_file($keys, $file)
  {
    if(count($keys) > 0){
      $fh = fopen($file, 'w');
      foreach($keys as $key) {
        if($key != ""){
          if(!fwrite($fh, $key."\n")) {
            throw new RuntimeException("Not able to write to the file.");
          }
        }
      }
      return fclose($fh);
    } else {
      unlink($file);
      return true;
    }
  }
}
