<?php declare(strict_types=1);

namespace Xtuple\Client\Query\Condition;

interface Condition {
  public function name(): string;

  public function property(): string;

  /**
   * @return mixed
   */
  public function value();
}
