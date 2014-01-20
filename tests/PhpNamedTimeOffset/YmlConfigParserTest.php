<?php

namespace PhpNamedTimeOffset;


use Symfony\Component\Yaml\Parser;

class YmlConfigParserTest extends \PHPUnit_Framework_TestCase {

  /**
   * @test
   * @expectedException \InvalidArgumentException
   * @expectedExceptionMessage Duplicate ID
   */
  public function dupeIdThrows() {
    $offset_field_parser = $this->getMock('PhpNamedTimeOffset\OffsetFieldParser');
    $parser = new YmlConfigParser(new Parser(), $offset_field_parser);
    $yml = <<<YML
offsets:
  - id: 1
    name: Coordinated Universal Time
    short: UTC
    offset: 0
  - id: 1
    name: Pacific Standard Time
    short: PST
    offset: -8
YML;
    $parser->parse($yml);
  }


  /**
   * @test
   */
  public function smoke() {
    $offset_field_parser = $this->getMock('PhpNamedTimeOffset\OffsetFieldParser');
    $offset_field_parser
        ->expects($this->any())
        ->method('toSeconds')
        ->will($this->returnValue(111));
    $parser = new YmlConfigParser(new Parser(), $offset_field_parser);
    $yml = <<<YML
offsets:
  - id: 2070001
    name: Pacific Daylight Time
    short: PDT
    offset: -7
  - id: 2080000
    name: Pacific Standard Time
    short: PST
    offset: -8
YML;
    $expected_config = array(
      2070001 => array(
        'name' => 'Pacific Daylight Time',
        'abbreviation' => 'PDT',
        'offset' => 111
      ),
      2080000 => array(
        'name' => 'Pacific Standard Time',
        'abbreviation' => 'PST',
        'offset' => 111
      )
    );
    $config = $parser->parse($yml);
    $this->assertEquals($expected_config, $config);
  }
}
