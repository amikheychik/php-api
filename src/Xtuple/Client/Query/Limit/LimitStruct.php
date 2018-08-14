<?php declare(strict_types=1);

namespace Xtuple\Client\Query\Limit;

use Xtuple\Util\Exception\Exception;
use Xtuple\Util\Exception\Throwable;

final class LimitStruct
  implements Limit {
  /** @var int */
  private $limit;
  /** @var int */
  private $page;

  /**
   * @throws Throwable
   *
   * @param int $limit - 0 for no limit
   * @param int $page  - positive integer
   */
  public function __construct(int $limit = 0, int $page = 1) {
    if ($page < 1) {
      throw new Exception('Page argument must be a positive integer, {page} given', [
        'page' => $page,
      ]);
    }
    $this->limit = $limit;
    $this->page = $page;
  }

  public function limit(): int {
    return $this->limit;
  }

  public function page(): int {
    return $this->page;
  }
}
