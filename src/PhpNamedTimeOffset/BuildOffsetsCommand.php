<?php

namespace PhpNamedTimeOffset;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Parser;

class BuildOffsetsCommand extends Command {
  const ARG_SOURCE = 'source';
  const ARG_TARGET = 'target';


  const COMMAND_NAME = 'build:offsets';


  protected function configure() {
    $this
        ->setName(self::COMMAND_NAME)
        ->setDescription('Generates the PHP configuration from YAML')
        ->addArgument(self::ARG_SOURCE, InputArgument::OPTIONAL, 'Path to the YAML file', 'app/config/offsets.yml')
        ->addArgument(self::ARG_TARGET, InputArgument::OPTIONAL, 'File to write to', __DIR__ . '/offsets.inc');
  }


  protected function execute(InputInterface $input, OutputInterface $output) {
    $parser = new Parser();
    $yml = file_get_contents($input->getArgument(self::ARG_SOURCE));
    $parsed = $parser->parse($yml);
    $var_export = var_export($parsed['offsets'], true);
    $timestamp = gmdate('Y-m-d H:i:s e');
    $md5_source = md5($yml);
    $php_config = <<<PHP
<?php
/**
 * DO NOT MODIFY
 * This file is generated by the {$this->getName()} command
 *
 * Generated at: $timestamp
 * MD5 of source: $md5_source
 */
return $var_export;
PHP;
    $target_path = $input->getArgument(self::ARG_TARGET);
    file_put_contents($target_path, $php_config);
    $output->writeln('Wrote configuration to file ' . $target_path);
  }
}
