<?php declare(strict_types=1);

namespace Xtuple\Client\Query\Search;

interface Search {
  public function query(): string;
}
