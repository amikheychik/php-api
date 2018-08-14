<?php declare(strict_types=1);

namespace Xtuple\Client\Result\Collection\Map;

use Xtuple\Util\Collection\Map\AbstractMap;

abstract class AbstractMapResult
  extends AbstractMap
  implements MapResult {
  public function __construct(MapResult $results) {
    parent::__construct($results);
  }
}
