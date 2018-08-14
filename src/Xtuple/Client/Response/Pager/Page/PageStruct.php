<?php declare(strict_types=1);

namespace Xtuple\Client\Response\Pager\Page;

final class PageStruct
  implements Page {
  /** @var int */
  private $size;
  /** @var int */
  private $number;

  /**
   * @param int $size
   * @param int $number - positive integer
   */
  public function __construct(int $size, int $number = 1) {
    $this->size = $size;
    $this->number = $number;
  }

  public function size(): int {
    return $this->size;
  }

  public function number(): int {
    return $this->number;
  }
}
