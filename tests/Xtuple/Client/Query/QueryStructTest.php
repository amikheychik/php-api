<?php declare(strict_types=1);

namespace Xtuple\Client\Query;

use PHPUnit\Framework\TestCase;

class QueryStructTest
  extends TestCase {
  public function testConstructor() {
    $query = new class (new QueryStruct([]))
      extends AbstractQuery {
    };
    self::assertEquals([], $query->value());
    $value = [
      'query' => [
        'title' => [
          'MATCHES' => 'xTuple',
        ],
        'price' => [
          'AT_LEAST' => 10.00,
        ],
      ],
      'orderby' => [
        'price' => 'ASC',
        'id' => 'DESC',
      ],
      'maxResults' => 30,
      'pageToken' => 0,
      'q' => 'Example',
    ];
    $query = new class (new QueryStruct($value))
      extends AbstractQuery {
    };
    self::assertEquals($value, $query->value());
  }
}
