<?php declare(strict_types=1);

namespace Xtuple\Client\Query\Condition\Condition;

use PHPUnit\Framework\TestCase;

class NotEqualsTest
  extends TestCase {
  public function testConstruct() {
    $condition = new NotEquals('id', 1);
    self::assertEquals('NOT_EQUALS', $condition->name());
    self::assertEquals('id', $condition->property());
    self::assertEquals(1, $condition->value());
  }
}
