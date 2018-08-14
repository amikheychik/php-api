<?php declare(strict_types=1);

namespace Xtuple\Client\Query\Condition;

use PHPUnit\Framework\TestCase;

class ConditionStructTest
  extends TestCase {
  public function testConstructor() {
    $condition = new class (new ConditionStruct('EQUALS', 'id', 1))
      extends AbstractCondition {
    };
    self::assertEquals('EQUALS', $condition->name());
    self::assertEquals('id', $condition->property());
    self::assertEquals(1, $condition->value());
  }
}
