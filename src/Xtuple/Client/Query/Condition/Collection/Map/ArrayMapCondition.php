<?php declare(strict_types=1);

namespace Xtuple\Client\Query\Condition\Collection\Map;

use Xtuple\Client\Query\Condition\Condition;
use Xtuple\Util\Collection\Map\ArrayMap\AbstractArrayMap;
use Xtuple\Util\Generics\Type\StrictType;

final class ArrayMapCondition
  extends AbstractArrayMap
  implements MapCondition {
  /**
   * @throws \Throwable
   *
   * @param iterable|Condition[] $elements
   */
  public function __construct(iterable $elements = []) {
    $type = new StrictType(Condition::class);
    $conditions = [];
    foreach ($elements as $element) {
      if ($element = $type->cast($element)) {
        /** @var Condition $element */
        $conditions["{$element->property()}:{$element->name()}"] = $element;
      }
    }
    parent::__construct($conditions);
  }
}
