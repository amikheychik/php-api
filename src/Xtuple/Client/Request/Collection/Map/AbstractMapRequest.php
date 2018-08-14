<?php declare(strict_types=1);

namespace Xtuple\Client\Request\Collection\Map;

use Xtuple\Util\Collection\Map\AbstractMap;

abstract class AbstractMapRequest
  extends AbstractMap
  implements MapRequest {
  public function __construct(MapRequest $requests) {
    parent::__construct($requests);
  }
}
