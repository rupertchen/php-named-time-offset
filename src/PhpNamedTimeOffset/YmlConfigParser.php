<?php

namespace PhpNamedTimeOffset;


use Symfony\Component\Yaml\Parser;

class YmlConfigParser {

  private $_yaml_parser;
  private $_offset_field_parser;


  public function __construct(Parser $yaml_parser, OffsetFieldParser $offset_field_parser) {
    $this->_yaml_parser = $yaml_parser;
    $this->_offset_field_parser = $offset_field_parser;
  }


  public function parse($yml) {
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
        'offset' => $this->_offset_field_parser->toSeconds($source['offset'])
      );
    }
    return $configs;
  }
}
