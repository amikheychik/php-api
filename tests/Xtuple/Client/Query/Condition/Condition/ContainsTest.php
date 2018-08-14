<?php declare(strict_types=1);

namespace Xtuple\Client\Query\Condition\Condition;

use PHPUnit\Framework\TestCase;

class ContainsTest
  extends TestCase {
  public function testConstruct() {
    $condition = new Contains('title', 'xTuple');
    self::assertEquals('MATCHES', $condition->name());
    self::assertEquals('title', $condition->property());
    self::assertEquals('xTuple', $condition->value());
  }
}
