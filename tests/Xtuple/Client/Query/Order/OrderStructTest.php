<?php declare(strict_types=1);

namespace Xtuple\Client\Query\Order;

use PHPUnit\Framework\TestCase;

class OrderStructTest
  extends TestCase {
  public function testConstructor() {
    $order = new class (new OrderStruct('ASC', 'title'))
      extends AbstractOrder {
    };
    self::assertEquals('ASC', $order->name());
    self::assertEquals('title', $order->property());
  }
}
