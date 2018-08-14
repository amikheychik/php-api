<?php declare(strict_types=1);

namespace Xtuple\Client\Query;

use PHPUnit\Framework\TestCase;
use Xtuple\Client\Query\Condition\Collection\Map\ArrayMapCondition;
use Xtuple\Client\Query\Condition\Condition\AtLeast;
use Xtuple\Client\Query\Condition\Condition\Matches;
use Xtuple\Client\Query\Limit\LimitStruct;
use Xtuple\Client\Query\Order\Collection\Map\ArrayMapOrder;
use Xtuple\Client\Query\Order\Order\Ascending;
use Xtuple\Client\Query\Order\Order\Descending;
use Xtuple\Client\Query\Search\SearchStruct;

class SearchQueryTest
  extends TestCase {
  public function testEmptyConstructor() {
    $query = new SearchQuery(new SearchStruct('Example'));
    self::assertEquals([
      'q' => 'Example',
    ], $query->value());
  }

  /**
   * @throws \Throwable
   */
  public function testFullConstructor() {
    $query = new SearchQuery(
      new SearchStruct('Example'),
      new ArrayMapCondition([
        new Matches('title', 'xTuple'),
        new AtLeast('price', 10.00),
      ]),
      new ArrayMapOrder([
        new Ascending('price'),
        new Descending('id'),
      ]),
      new LimitStruct(30, 2)
    );
    self::assertEquals([
      'q' => 'Example',
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
      'pageToken' => 1,
    ], $query->value());
  }
}
