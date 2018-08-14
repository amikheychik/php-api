<?php declare(strict_types=1);

namespace Xtuple\Client\Query\Limit;

abstract class AbstractLimit
  implements Limit {
  /** @var Limit */
  private $limit;

  public function __construct(Limit $limit) {
    $this->limit = $limit;
  }

  public final function limit(): int {
    return $this->limit->limit();
  }

  public final function page(): int {
    return $this->limit->page();
  }
}
