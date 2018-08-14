<?php declare(strict_types=1);

namespace Xtuple\Client\Query\Order\Collection\Map;

use Xtuple\Client\Query\Order\Order;
use Xtuple\Util\Collection\Map\Map;

interface MapOrder
  extends Map {
  /**
   * @param string $key
   *
   * @return null|Order
   */
  public function get(string $key);

  /**
   * @return null|Order
   */
  public function current();
}
