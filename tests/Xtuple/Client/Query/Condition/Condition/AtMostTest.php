<?php declare(strict_types=1);

namespace Xtuple\Client\Query\Condition\Condition;

use PHPUnit\Framework\TestCase;

class AtMostTest
  extends TestCase {
  public function testConstruct() {
    $condition = new AtMost('price', 10.00);
    self::assertEquals('AT_MOST', $condition->name());
    self::assertEquals('price', $condition->property());
    self::assertEquals(10.00, $condition->value());
  }
}
