<?php declare(strict_types=1);

namespace Xtuple\Client\Result\Collection\Map;

use Xtuple\Client\Result\ResultFromHTTPResult;
use Xtuple\Util\HTTP\Client\Result\Collection\Map\MapResult as MapHTTPResult;

final class MapResultFromMapHTTPResult
  extends AbstractMapResult {
  public function __construct(MapHTTPResult $results) {
    $elements = [];
    foreach ($results as $key => $result) {
      $elements[$key] = new ResultFromHTTPResult($result);
    }
    /** @noinspection PhpUnhandledExceptionInspection */
    parent::__construct(new ArrayMapResult($elements));
  }
}
