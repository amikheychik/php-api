<?php declare(strict_types=1);

namespace Xtuple\Client\Response\Pager;

use PHPUnit\Framework\TestCase;
use Xtuple\Client\Response\Pager\Page\PageStruct;

class PagerStructTest
  extends TestCase {
  public function testConstructor() {
    $pager = new class (new PagerStruct(new PageStruct(30), 40))
      extends AbstractPager {
    };
    self::assertEquals(30, $pager->page()->size());
    self::assertEquals(1, $pager->page()->number());
    self::assertEquals(40, $pager->total());
  }
}
