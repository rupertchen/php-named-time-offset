<?php

namespace PhpNamedTimeOffset;


class OffsetsYmlTest extends \PHPUnit_Framework_TestCase {

  /**
   * @test
   */
  public function offsetsIncIsUpdated() {
    // Test that the md5 in offsets.inc matches the current yml file
    $php_md5 = $this->_getPhpMd5();
    $yml_md5 = $this->_getYmlMd5();
    $this->assertEquals($yml_md5, $php_md5, 'offsets.inc is out of date.');
  }


  private function _getPhpMd5() {
    $filepath = __DIR__ . '/../../src/PhpNamedTimeOffset/offsets.inc';
    $handle = @fopen($filepath, 'r');
    if ($handle) {
      while (($buffer = fgets($handle, 1024)) !== false) {
        preg_match('/MD5 of source: ([a-z0-9]{32})$/', $buffer, $matches);
        if ($matches) {
          fclose($handle);
          return $matches[1];
        }
      }
      fclose($handle);
    }
    throw new \UnexpectedValueException('Did not find MD5 in file');
  }


  private function _getYmlMd5() {
    $filepath = __DIR__ . '/../../app/config/offsets.yml';
    return md5_file($filepath);
  }
}
