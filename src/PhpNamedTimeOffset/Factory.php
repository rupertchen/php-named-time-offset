<?php

namespace PhpNamedTimeOffset;


use InvalidArgumentException;

class Factory {

  /** @var array */
  private $_offset_cache;
  /** @var array */
  private $_offset_configs;


  public function __construct($configs) {
    $this->_offset_cache = array();
    $this->_offset_configs = $configs;
  }


  /**
   * Return a new instance of the default factory
   *
   * @return Factory
   */
  public static function CreateDefault() {
    $configs = require(self::GetDefaultConfigFile());
    return new Factory($configs);
  }


  /**
   * Get the default configuration file path
   *
   * @return string
   */
  public static function GetDefaultConfigFile() {
    return __DIR__ . '/offsets.inc';
  }


  /**
   * @param int $id
   * @return NamedTimeOffset
   */
  public function fromId($id) {
    if (!isset($this->_offset_cache[$id])) {
      if (!isset($this->_offset_configs[$id])) {
        throw new InvalidArgumentException('Unknown ID (' . $id . ')');
      }
      $offset_config = $this->_offset_configs[$id];
      $offset_config['id'] = $id;
      $x = new NamedTimeOffset($offset_config);
      $this->_offset_cache[$id] = $x;
    }

    return $this->_offset_cache[$id];
  }


  /**
   * @return int[]
   */
  public function getIds() {
    return array_keys($this->_offset_configs);
  }
}
