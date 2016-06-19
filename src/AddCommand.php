<?php namespace MarkMyers;

use RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use GuzzleHttp\Client;

class AddCommand extends Command {

  public function configure()
  {
    $this->setName('add')
         ->setDescription('Add GitHub user keys to `~/.ssh/authorized_keys` for pairing')
         ->addArgument('user', InputArgument::REQUIRED, 'Users keys to add');
  }

  public function execute(InputInterface $input, OutputInterface $output)
  {
    $response = (new Client)->get(self::DEFAULT_HOSTNAME.'/users/'.$input->getArgument('user').'/keys');

    $this->write_to_file(json_decode($response->getBody()), self::getKeysFile(), $input->getArgument('user'));
    $output->writeln("<info>Successfully added ".$input->getArgument('user')." to your authorized keys file</info>");
  }

  private function write_to_file($keys, $file, $user)
  {
    if (!file_exists($file)) {
      touch($file);
    }
    $fh = fopen($file, 'a');
    foreach($keys as $key) {
      $gh = $key->key . " " . $user . "\n";
      if(!fwrite($fh, $gh)) {
        throw new RuntimeException("Not able to write to the file.");
      }
    }
    fclose($fh);
  }
}
