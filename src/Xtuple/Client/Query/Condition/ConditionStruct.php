<?php declare(strict_types=1);

namespace Xtuple\Client\Query\Condition;

final class ConditionStruct
  implements Condition {
  /** @var string */
  private $name;
  /** @var string */
  private $property;
  /** @var mixed */
  private $value;

  /**
   * @param string $name
   * @param string $property
   * @param mixed  $value
   */
  public function __construct(string $name, string $property, $value) {
    $this->name = $name;
    $this->property = $property;
    $this->value = $value;
  }

  public function name(): string {
    return $this->name;
  }

  public function property(): string {
    return $this->property;
  }

  public function value() {
    return $this->value;
  }
}
