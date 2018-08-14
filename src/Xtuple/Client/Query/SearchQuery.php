<?php declare(strict_types=1);

namespace Xtuple\Client\Query;

use Xtuple\Client\Query\Condition\Collection\Map\MapCondition;
use Xtuple\Client\Query\Limit\Limit;
use Xtuple\Client\Query\Order\Collection\Map\MapOrder;
use Xtuple\Client\Query\Search\Search;

final class SearchQuery
  extends AbstractQuery {
  public function __construct(Search $search, ?MapCondition $conditions = null, ?MapOrder $ordering = null,
                              ?Limit $limit = null) {
    parent::__construct(new QueryStruct([
        'q' => $search->query(),
      ] + (new BuildQuery($conditions, $ordering, $limit))->value()));
  }
}
