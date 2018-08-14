<?php declare(strict_types=1);

namespace Xtuple\Client\Query\Limit;

use PHPUnit\Framework\TestCase;

class LimitStructTest
  extends TestCase {
  /**
   * @throws \Throwable
   */
  public function testConstructor() {
    $limit = new class (new LimitStruct())
      extends AbstractLimit {
    };
    self::assertEquals(0, $limit->limit());
    self::assertEquals(1, $limit->page());
    $limit = new class (new LimitStruct(30, 2))
      extends AbstractLimit {
    };
    self::assertEquals(30, $limit->limit());
    self::assertEquals(2, $limit->page());
  }

  /**
   * @expectedException  \Xtuple\Util\Exception\Throwable
   * @expectedExceptionMessage Page argument must be a positive integer, 0 given
   */
  public function testConstructorException() {
    new LimitStruct(0, 0);
  }
}
