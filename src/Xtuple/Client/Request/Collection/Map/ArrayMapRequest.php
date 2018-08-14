<?php declare(strict_types=1);

namespace Xtuple\Client\Request\Collection\Map;

use Xtuple\Client\Request\Request;
use Xtuple\Util\HTTP\Request\Collection\Map\AbstractMapRequest;
use Xtuple\Util\HTTP\Request\Collection\Map\ArrayMapRequest as ArrayMapHTTPRequest;

final class ArrayMapRequest
  extends AbstractMapRequest
  implements MapRequest {
  /**
   * @throws \Throwable
   *
   * @param iterable|Request[] $requests
   */
  public function __construct(iterable $requests) {
    parent::__construct(new ArrayMapHTTPRequest($requests));
  }
}
