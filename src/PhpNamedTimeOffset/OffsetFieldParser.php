<?php

namespace PhpNamedTimeOffset;

use InvalidArgumentException;

/**
 * Parse the offset format
 */
class OffsetFieldParser {
  const SECONDS_PER_HOUR = 3600;
  const SECONDS_PER_MINUTE = 60;


  /**
   * Converts the offset string used in the config to seconds.
   *
   * @param string $source
   * @return int
   */
  public function toSeconds($source) {
    if (!(is_string($source) || is_int($source))) {
      throw new InvalidArgumentException(sprintf('Invalid offset type (%s)', gettype($source)));
    }

    preg_match('/(?<sign>-)?(?<hours>\\d+)(?::(?<minutes>\\d+))?/', $source, $matches);
    if (!$matches) {
      throw new InvalidArgumentException(sprintf('Invalid offset (%s)', $source));
    }
    $hours = intval($matches['hours']);
    if (isset($matches['minutes'])) {
      $minutes = intval($matches['minutes']);
    } else {
      $minutes = 0;
    }
    $sign = $matches['sign'] ? -1 : 1;
    return $sign * ($hours * self::SECONDS_PER_HOUR + $minutes * self::SECONDS_PER_MINUTE);
  }
}
