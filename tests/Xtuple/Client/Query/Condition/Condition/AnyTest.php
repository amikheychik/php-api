<?php declare(strict_types=1);

namespace Xtuple\Client\Query\Condition\Condition;

use PHPUnit\Framework\TestCase;

class AnyTest
  extends TestCase {
  public function testConstruct() {
    $condition = new Any('id', [1, 2, 3]);
    self::assertEquals('ANY', $condition->name());
    self::assertEquals('id', $condition->property());
    self::assertEquals([1, 2, 3], $condition->value());
  }
}
