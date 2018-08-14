<?php declare(strict_types=1);

namespace Xtuple\Client\Query\Search;

use PHPUnit\Framework\TestCase;

class SearchStructTest
  extends TestCase {
  public function testConstructor() {
    $search = new class (new SearchStruct('xTuple'))
      extends AbstractSearch {
    };
    self::assertEquals('xTuple', $search->query());
  }
}
