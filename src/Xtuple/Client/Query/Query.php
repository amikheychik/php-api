<?php declare(strict_types=1);

namespace Xtuple\Client\Query;

interface Query {
  public function value(): array;
}
