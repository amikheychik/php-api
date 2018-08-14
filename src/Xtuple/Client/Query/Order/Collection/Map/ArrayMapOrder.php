<?php declare(strict_types=1);

namespace Xtuple\Client\Query\Order\Collection\Map;

use Xtuple\Client\Query\Order\Order;
use Xtuple\Util\Collection\Map\ArrayMap\StrictType\AbstractStrictlyTypedArrayMap;

final class ArrayMapOrder
  extends AbstractStrictlyTypedArrayMap
  implements MapOrder {
  /**
   * @throws \Throwable
   *
   * @param iterable|Order[] $elements
   */
  public function __construct(iterable $elements = []) {
    parent::__construct(Order::class, $elements, 'property');
  }
}
