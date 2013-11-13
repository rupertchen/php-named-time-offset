<?php

namespace PhpNamedTimeOffset\Test;


use PhpNamedTimeOffset\Factory;

class FactoryTest extends \PHPUnit_Framework_TestCase {

  private function _getDummyConfigs() {
    return array(
      1 => array(
        'name' => 'dummy 1',
        'abbreviation' => 'd1',
        'offset' => 0
      ),
      2 => array(
        'name' => 'dummy 2',
        'abbreviation' => 'd2',
        'offset' => 3600
      ),
      3 => array(
        'name' => 'dummy 3',
        'abbreviation' => 'd3',
        'offset' => 7200
      )
    );
  }


  /**
   * @test
   */
  public function returnsSameInstanceForId() {
    $factory = new Factory($this->_getDummyConfigs());
    $obj1 = $factory->fromId(1);
    $obj2 = $factory->fromId(1);
    $obj3 = $factory->fromId(2);
    $this->assertSame($obj1, $obj2);
    $this->assertNotSame($obj1, $obj3);
  }


  /**
   * @test
   * @expectedException \InvalidArgumentException
   */
  public function fromIdThrowsIfUnknownId() {
    $factory = new Factory($this->_getDummyConfigs());
    $factory->fromId(123456);
  }


  /**
   * @test
   */
  public function getAllOffsetIds() {
    $factory = new Factory($this->_getDummyConfigs());
    $ids = $factory->getIds();
    sort($ids);
    $this->assertEquals(array(1, 2, 3), $ids);
  }


  /**
   * @test
   */
  public function noDupeIds() {
    $factory = Factory::CreateDefault();
    $used_ids = array();
    foreach ($factory->getIds() as $id) {
      $this->assertFalse(isset($used_ids[$id]));
      $used_ids[$id] = true;
    }
  }


  /**
   * @test
   */
  public function verifyAllKnownOffsets() {
    $factory = Factory::CreateDefault();
    $dump = array();
    foreach ($factory->getIds() as $id) {
      $offset = $factory->fromId($id);
      $dump[$id] = array(
        'id' => $offset->getId(),
        'name' => $offset->getName(),
        'abbreviation' => $offset->getAbbreviation(),
        'offset' => $offset->getOffset(),
        'difference' => $offset->getDifference()
      );
    }
    sort($dump);

    file_put_contents(__DIR__ . '/verifyAllKnownOffsets.actual.php', '<?php return ' . var_export($dump, true) . ';');
    $expected = require(__DIR__ . '/verifyAllKnownOffsets.expected.php');
    $this->assertEquals($expected, $dump);
  }
}
