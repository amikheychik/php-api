<?php declare(strict_types=1);

namespace Xtuple\Client\Query\Order;

final class OrderStruct
  implements Order {
  /** @var string */
  private $name;
  /** @var string */
  private $property;

  public function __construct(string $name, string $property) {
    $this->name = $name;
    $this->property = $property;
  }

  public function name(): string {
    return $this->name;
  }

  public function property(): string {
    return $this->property;
  }
}
