<?php declare(strict_types=1);

namespace Xtuple\Client\Query\Condition\Condition;

use PHPUnit\Framework\TestCase;

class AtLeastTest
  extends TestCase {
  public function testConstruct() {
    $condition = new AtLeast('price', 10.00);
    self::assertEquals('AT_LEAST', $condition->name());
    self::assertEquals('price', $condition->property());
    self::assertEquals(10.00, $condition->value());
  }
}
