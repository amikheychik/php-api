<?php declare(strict_types=1);

namespace Xtuple\Client\Response\Pager\Page;

use PHPUnit\Framework\TestCase;

class PageStructTest
  extends TestCase {
  public function testConstruct() {
    $page = new class (new PageStruct(30))
      extends AbstractPage {
    };
    self::assertEquals(30, $page->size());
    self::assertEquals(1, $page->number());
    $page = new class (new PageStruct(30, 2))
      extends AbstractPage {
    };
    self::assertEquals(30, $page->size());
    self::assertEquals(2, $page->number());
  }
}
