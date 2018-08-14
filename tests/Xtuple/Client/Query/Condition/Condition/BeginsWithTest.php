<?php declare(strict_types=1);

namespace Xtuple\Client\Query\Condition\Condition;

use PHPUnit\Framework\TestCase;

class BeginsWithTest
  extends TestCase {
  public function testConstruct() {
    $condition = new BeginsWith('title', 'xTuple');
    self::assertEquals('BEGINS_WITH', $condition->name());
    self::assertEquals('title', $condition->property());
    self::assertEquals('xTuple', $condition->value());
  }
}
