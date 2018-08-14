<?php declare(strict_types=1);

namespace Xtuple\Client\Query\Order\Collection\Map;

use PHPUnit\Framework\TestCase;
use Xtuple\Client\Query\Order\Order\Ascending;
use Xtuple\Client\Query\Order\Order\Descending;

class ArrayMapOrderTest
  extends TestCase {
  /**
   * @throws \Throwable
   */
  public function testConstructor() {
    $sorting = new class (new ArrayMapOrder())
      extends AbstractMapOrder {
    };
    self::assertTrue($sorting->isEmpty());
    self::assertEquals(0, $sorting->count());
    $sorting = new class (new ArrayMapOrder([
      new Ascending('title'),
      new Descending('title'),
      new Ascending('price'),
    ]))
      extends AbstractMapOrder {
    };
    self::assertFalse($sorting->isEmpty());
    self::assertEquals(2, $sorting->count());
    self::assertEquals('DESC', $sorting->get('title')->name());
  }
}
