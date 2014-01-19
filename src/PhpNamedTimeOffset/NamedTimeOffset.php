<?php

namespace PhpNamedTimeOffset;

class NamedTimeOffset {

  /** @var  int */
  private $_id;
  /** @var  string */
  private $_name;
  /** @var  string */
  private $_abbreviation;
  /** @var  int */
  private $_offset;
  /** @var string */
  private $_cached_difference;


  public function __construct(array $conf) {
    $this->_id = $conf['id'];
    $this->_name = $conf['name'];
    $this->_abbreviation = $conf['short'];
    $this->_offset = $conf['offset'];
  }


  /**
   * Full name of this offset
   *
   * @return string
   */
  public function getName() {
    return $this->_name;
  }


  /**
   * Common abbreviation for this offset
   *
   * @return string
   */
  public function getAbbreviation() {
    return $this->_abbreviation;
  }


  /**
   * @return int
   */
  public function getId() {
    return $this->_id;
  }


  /**
   * Offset from UTC in seconds
   *
   * @return int
   */
  public function getOffset() {
    return $this->_offset;
  }


  /**
   * Difference in hours and minutes from UTC
   *
   * The resulting string matches "P" from the date format. E.g., +00:00
   * and -07:00.
   *
   * @return string
   */
  public function getDifference() {
    if ($this->_cached_difference === null) {
      $sign = ($this->_offset < 0) ? '-' : '+';
      $hours = floor(abs($this->_offset) / 3600);
      $minutes = floor((abs($this->_offset) % 3600) / 60);
      $this->_cached_difference = sprintf('%s%02d:%02d', $sign, $hours, $minutes);
    }
    return $this->_cached_difference;
  }
}
