<?php declare(strict_types=1);

namespace Xtuple\Client\Query\Limit;

interface Limit {
  public function limit(): int;

  public function page(): int;
}
