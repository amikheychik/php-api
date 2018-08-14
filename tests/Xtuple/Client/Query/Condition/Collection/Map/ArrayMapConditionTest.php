<?php declare(strict_types=1);

namespace Xtuple\Client\Query\Condition\Collection\Map;

use PHPUnit\Framework\TestCase;
use Xtuple\Client\Query\Condition\Condition\AtLeast;
use Xtuple\Client\Query\Condition\Condition\AtMost;
use Xtuple\Client\Query\Condition\Condition\Contains;

class ArrayMapConditionTest
  extends TestCase {
  /**
   * @throws \Throwable
   */
  public function testConstructor() {
    $conditions = new class (new ArrayMapCondition())
      extends AbstractMapCondition {
    };
    self::assertTrue($conditions->isEmpty());
    self::assertEquals(0, $conditions->count());
    $conditions = new class (new ArrayMapCondition([
      new AtLeast('price', 10.00),
      new AtMost('price', 20.00),
      new Contains('description', 'example'),
    ]))
      extends AbstractMapCondition {
    };
    self::assertFalse($conditions->isEmpty());
    self::assertEquals(3, $conditions->count());
    self::assertEquals(10.00, $conditions->get('price:AT_LEAST')->value());
    self::assertNull($conditions->get('price'));
    self::assertNull($conditions->get('AT_LEAST'));
    $conditions = new class (new ArrayMapCondition([
      new AtLeast('price', 10.00),
      new AtLeast('price', 20.00),
      new Contains('description', 'example'),
    ]))
      extends AbstractMapCondition {
    };
    self::assertEquals(2, $conditions->count());
    self::assertEquals(20.00, $conditions->get('price:AT_LEAST')->value());
  }
}
