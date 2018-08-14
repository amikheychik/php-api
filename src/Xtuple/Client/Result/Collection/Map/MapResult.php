<?php declare(strict_types=1);

namespace Xtuple\Client\Result\Collection\Map;

use Xtuple\Client\Result\Result;
use Xtuple\Util\Collection\Map\Map;

interface MapResult
  extends Map {
  /**
   * @return null|Result
   */
  public function current();

  /**
   * @param string $key
   *
   * @return null|Result
   */
  public function get(string $key);
}
