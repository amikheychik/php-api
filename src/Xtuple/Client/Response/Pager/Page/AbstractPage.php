<?php declare(strict_types=1);

namespace Xtuple\Client\Response\Pager\Page;

abstract class AbstractPage
  implements Page {
  /** @var Page */
  private $page;

  public function __construct(Page $page) {
    $this->page = $page;
  }

  public final function size(): int {
    return $this->page->size();
  }

  public final function number(): int {
    return $this->page->number();
  }
}
