<?php declare(strict_types=1);

namespace Xtuple\Client\Query\Order\Collection\Map;

use Xtuple\Util\Collection\Map\AbstractMap;

abstract class AbstractMapOrder
  extends AbstractMap
  implements MapOrder {
  public function __construct(MapOrder $sorting) {
    parent::__construct($sorting);
  }
}
