<?php declare(strict_types=1);

namespace Xtuple\Client\Query\Search;

final class SearchStruct
  implements Search {
  /** @var string */
  private $query;

  public function __construct(string $query) {
    $this->query = $query;
  }

  public function query(): string {
    return $this->query;
  }
}
