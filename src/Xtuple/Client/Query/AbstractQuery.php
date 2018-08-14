<?php declare(strict_types=1);

namespace Xtuple\Client\Query;

abstract class AbstractQuery
  implements Query {
  /** @var Query */
  private $query;

  public function __construct(Query $query) {
    $this->query = $query;
  }

  public final function value(): array {
    return $this->query->value();
  }
}
