<?php declare(strict_types=1);

namespace Xtuple\Client\Query\Order\Order;

use PHPUnit\Framework\TestCase;

class AscendingTest
  extends TestCase {
  public function testConstructor() {
    $order = new Ascending('title');
    self::assertEquals('ASC', $order->name());
    self::assertEquals('title', $order->property());
  }
}
