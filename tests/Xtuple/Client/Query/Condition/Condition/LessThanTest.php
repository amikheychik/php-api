<?php declare(strict_types=1);

namespace Xtuple\Client\Query\Condition\Condition;

use PHPUnit\Framework\TestCase;

class LessThanTest
  extends TestCase {
  public function testConstruct() {
    $condition = new LessThan('price', 10.00);
    self::assertEquals('LESS_THAN', $condition->name());
    self::assertEquals('price', $condition->property());
    self::assertEquals(10.00, $condition->value());
  }
}
