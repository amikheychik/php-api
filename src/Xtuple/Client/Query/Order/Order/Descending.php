<?php declare(strict_types=1);

namespace Xtuple\Client\Query\Order\Order;

use Xtuple\Client\Query\Order\AbstractOrder;
use Xtuple\Client\Query\Order\OrderStruct;

final class Descending
  extends AbstractOrder {
  public function __construct(string $property) {
    parent::__construct(new OrderStruct('DESC', $property));
  }
}
