<?php declare(strict_types=1);

namespace Xtuple\Client\Query\Condition\Condition;

use PHPUnit\Framework\TestCase;

class NotAnyTest
  extends TestCase {
  public function testConstruct() {
    $condition = new NotAny('id', [4, 5, 6]);
    self::assertEquals('NOT_ANY', $condition->name());
    self::assertEquals('id', $condition->property());
    self::assertEquals([4, 5, 6], $condition->value());
  }
}
