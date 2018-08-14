<?php declare(strict_types=1);

namespace Xtuple\Client\Query\Condition\Condition;

use Xtuple\Client\Query\Condition\AbstractCondition;
use Xtuple\Client\Query\Condition\ConditionStruct;

final class AtLeast
  extends AbstractCondition {
  public function __construct(string $property, $value) {
    parent::__construct(new ConditionStruct('AT_LEAST', $property, $value));
  }
}
