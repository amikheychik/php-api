<?php declare(strict_types=1);

namespace Xtuple\Client\Query\Condition\Collection\Map;

use Xtuple\Client\Query\Condition\Condition;
use Xtuple\Util\Collection\Map\Map;

interface MapCondition
  extends Map {
  /**
   * @param string $key - property:operator
   *
   * @return null|Condition
   */
  public function get(string $key);

  /**
   * @return null|Condition
   */
  public function current();
}
