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
  /** @var Parser */
  private $_yaml_parser;
  /** @var OffsetParser */
  private $_offset_parser;


  protected function configure() {
    $this
        ->setName(self::COMMAND_NAME)
        ->setDescription('Generates the PHP configuration from YAML')
        ->addArgument(self::ARG_SOURCE, InputArgument::OPTIONAL, 'Path to the YAML file', 'app/config/offsets.yml')
        ->addArgument(self::ARG_TARGET, InputArgument::OPTIONAL, 'File to write to', __DIR__ . '/offsets.inc');
    $this->_yaml_parser = new Parser();
    $this->_offset_parser = new OffsetParser();
  }


  protected function execute(InputInterface $input, OutputInterface $output) {
    // TODO: extract this YAML parser, test dupe id and config building
    $yml = file_get_contents($input->getArgument(self::ARG_SOURCE));
    $parsed = $this->_yaml_parser->parse($yml);
    $configs = array();
    foreach ($parsed['offsets'] as $source) {
      $id = $source['id'];
      if (isset($configs[$id])) {
        throw new \InvalidArgumentException("Duplicate ID found ($id)");
      }
      $configs[$id] = array(
        'name' => $source['name'],
        'abbreviation' => $source['short'],
        'offset' => $this->_offset_parser->toSeconds($source['offset'])
      );
    }
    $var_export = var_export($configs, true);
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
