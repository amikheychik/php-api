<?php declare(strict_types=1);

namespace Xtuple\Client\Response\Pager\Page;

interface Page {
  public function size(): int;

  public function number(): int;
}
