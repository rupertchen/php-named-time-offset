<?php

namespace PhpNamedTimeOffset;


class OffsetParserTest extends \PHPUnit_Framework_TestCase {

  /** @var OffsetParser */
  private $_parser;


  /**
   * @test
   * @dataProvider provider_toSeconds
   */
  public function toSeconds($source, $seconds) {
    $this->assertEquals($seconds, $this->_parser->toSeconds($source));
  }


  public function provider_toSeconds() {
    return array(
      // base
      array('0', 0),
      // positive hour only
      array('1', 3600),
      array('2', 7200),
      // negative hour only
      array('-1', -3600),
      array('-2', -7200),
      // positive hour and minute
      array('0:0', 0),
      array('1:1', 3660),
      array('2:02', 7320),
      array('03:59', 14340),
      array('16:30', 59400),
      // negative hour and minute
      array('-00:00', 0),
      array('-8:35', -30900),
      // additional spaces
      array('   -03', -10800),
      array('4     ', 14400)
    );
  }


  protected function setUp() {
    $this->_parser = new OffsetParser();
  }


  protected function tearDown() {
    $this->_parser = null;
  }
}