<?php declare(strict_types=1);

namespace Xtuple\Client\Response\Pager;

use Xtuple\Client\Response\Pager\Page\Page;

final class PagerStruct
  implements Pager {
  /** @var Page */
  private $page;
  /** @var int */
  private $total;

  public function __construct(Page $page, int $total) {
    $this->page = $page;
    $this->total = $total;
  }

  public function page(): Page {
    return $this->page;
  }

  public function total(): int {
    return $this->total;
  }
}
