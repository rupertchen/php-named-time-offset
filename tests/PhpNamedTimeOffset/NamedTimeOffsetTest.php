<?php

namespace PhpNamedTimeOffset;


class NamedTimeOffsetTest extends \PHPUnit_Framework_TestCase {

  /**
   * @test
   */
  public function creation() {
    $x = new NamedTimeOffset($this->_makeConf());
    $this->assertNotNull($x);
  }


  private function _makeConf() {
    return array(
      'id' => 0,
      'name' => 'full-name',
      'short' => 'xxx',
      'offset' => 0
    );
  }


  /**
   * @test
   */
  public function getIdEchosConf() {
    $conf = $this->_makeConf();
    $conf['id'] = 54321;
    $x = new NamedTimeOffset($conf);
    $this->assertEquals(54321, $x->getId());
  }


  /**
   * @test
   */
  public function getNameEchosConf() {
    $conf = $this->_makeConf();
    $conf['name'] = 'test-name';
    $x = new NamedTimeOffset($conf);
    $this->assertEquals('test-name', $x->getName());
  }


  /**
   * @test
   */
  public function getAbbreviationEchosConf() {
    $conf = $this->_makeConf();
    $conf['short'] = 'shorthand-name';
    $x = new NamedTimeOffset($conf);
    $this->assertEquals('shorthand-name', $x->getAbbreviation());
  }


  /**
   * @test
   * @dataProvider provider_getOffsetAndDifference
   */
  public function getOffsetAndDifference($offset, $expected_offset, $expected_difference) {
    $conf = $this->_makeConf();
    $conf['offset'] = $offset;
    $x = new NamedTimeOffset($conf);
    $this->assertEquals($expected_offset, $x->getOffset());
    $this->assertEquals($expected_difference, $x->getDifference());
  }


  public function provider_getOffsetAndDifference() {
    return array(
      array(0, 0, '+00:00'),
      array(3600, 3600, '+01:00'),
      array(-9000, -9000, '-02:30')
    );
  }
}
