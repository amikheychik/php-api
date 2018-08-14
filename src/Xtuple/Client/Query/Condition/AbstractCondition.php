<?php declare(strict_types=1);

namespace Xtuple\Client\Query\Condition;

abstract class AbstractCondition
  implements Condition {
  /** @var Condition */
  private $condition;

  public function __construct(Condition $condition) {
    $this->condition = $condition;
  }

  public final function name(): string {
    return $this->condition->name();
  }

  public final function property(): string {
    return $this->condition->property();
  }

  public final function value() {
    return $this->condition->value();
  }
}
