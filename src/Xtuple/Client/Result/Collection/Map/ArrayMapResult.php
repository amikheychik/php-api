<?php declare(strict_types=1);

namespace Xtuple\Client\Result\Collection\Map;

use Xtuple\Client\Result\Result;
use Xtuple\Util\Collection\Map\ArrayMap\StrictType\AbstractStrictlyTypedArrayMap;

final class ArrayMapResult
  extends AbstractStrictlyTypedArrayMap
  implements MapResult {
  /**
   * @throws \Throwable
   *
   * @param iterable|Result[] $results
   */
  public function __construct(iterable $results = []) {
    parent::__construct(Result::class, $results, 'key');
  }
}
