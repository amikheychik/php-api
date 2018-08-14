<?php declare(strict_types=1);

namespace Xtuple\Client\Query\Condition\Collection\Map;

use Xtuple\Util\Collection\Map\AbstractMap;

abstract class AbstractMapCondition
  extends AbstractMap
  implements MapCondition {
  public function __construct(MapCondition $conditions) {
    parent::__construct($conditions);
  }
}
