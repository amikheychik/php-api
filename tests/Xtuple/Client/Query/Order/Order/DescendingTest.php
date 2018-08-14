<?php declare(strict_types=1);

namespace Xtuple\Client\Query\Order\Order;

use PHPUnit\Framework\TestCase;

class DescendingTest
  extends TestCase {
  public function testConstructor() {
    $order = new Descending('title');
    self::assertEquals('DESC', $order->name());
    self::assertEquals('title', $order->property());
  }
}
