<?php declare(strict_types=1);

namespace Xtuple\Client\Response\Pager;

use Xtuple\Client\Response\Pager\Page\Page;

abstract class AbstractPager
  implements Pager {
  /** @var Pager */
  private $pager;

  public function __construct(Pager $pager) {
    $this->pager = $pager;
  }

  public final function page(): Page {
    return $this->pager->page();
  }

  public final function total(): int {
    return $this->pager->total();
  }
}
