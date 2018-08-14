<?php declare(strict_types=1);

namespace Xtuple\Client\Query\Condition\Condition;

use Xtuple\Client\Query\Condition\AbstractCondition;
use Xtuple\Client\Query\Condition\ConditionStruct;

final class Any
  extends AbstractCondition {
  public function __construct(string $property, array $value) {
    parent::__construct(new ConditionStruct('ANY', $property, $value));
  }
}
