<?php declare(strict_types=1);

namespace Xtuple\Client\Query\Order;

interface Order {
  public function name(): string;

  public function property(): string;
}
