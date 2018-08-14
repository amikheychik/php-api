<?php declare(strict_types=1);

namespace Xtuple\Client\Query;

final class QueryStruct
  implements Query {
  /** @var array */
  private $value;

  public function __construct(array $value) {
    $this->value = $value;
  }

  public function value(): array {
    return $this->value;
  }
}
