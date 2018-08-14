<?php declare(strict_types=1);

namespace Xtuple\Client\Query\Search;

abstract class AbstractSearch
  implements Search {
  /** @var Search */
  private $search;

  public function __construct(Search $search) {
    $this->search = $search;
  }

  public final function query(): string {
    return $this->search->query();
  }
}
