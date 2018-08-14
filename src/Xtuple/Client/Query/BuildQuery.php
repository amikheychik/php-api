<?php declare(strict_types=1);

namespace Xtuple\Client\Query;

use Xtuple\Client\Query\Condition\Collection\Map\ArrayMapCondition;
use Xtuple\Client\Query\Condition\Collection\Map\MapCondition;
use Xtuple\Client\Query\Limit\Limit;
use Xtuple\Client\Query\Limit\LimitStruct;
use Xtuple\Client\Query\Order\Collection\Map\ArrayMapOrder;
use Xtuple\Client\Query\Order\Collection\Map\MapOrder;

final class BuildQuery
  extends AbstractQuery {
  public function __construct(?MapCondition $conditions = null, ?MapOrder $order = null, ?Limit $limit = null) {
    $value = ['query' => [], 'orderby' => []];
    /** @noinspection PhpUnhandledExceptionInspection - $elements are empty */
    $conditions = $conditions ?: new ArrayMapCondition();
    foreach ($conditions as $condition) {
      $value['query'][$condition->property()] = [
        $condition->name() => $condition->value(),
      ];
    }
    /** @noinspection PhpUnhandledExceptionInspection - $elements are empty */
    $order = $order ?: new ArrayMapOrder();
    foreach ($order as $by) {
      $value['orderby'][$by->property()] = $by->name();
    }
    /** @noinspection PhpUnhandledExceptionInspection */
    $limit = $limit ?: new LimitStruct();
    parent::__construct(new QueryStruct(array_filter($value) + ($limit->limit()
        ? [
          'maxResults' => $limit->limit(),
          'pageToken' => ($limit->page() > 0 ? $limit->page() : 1) - 1,
        ]
        : [])
    ));
  }
}
