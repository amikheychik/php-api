<?php declare(strict_types=1);

namespace Xtuple\Client\Query\Order;

abstract class AbstractOrder
  implements Order {
  /** @var Order */
  private $order;

  public function __construct(Order $order) {
    $this->order = $order;
  }

  public final function name(): string {
    return $this->order->name();
  }

  public final function property(): string {
    return $this->order->property();
  }
}
