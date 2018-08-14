<?php declare(strict_types=1);

namespace Xtuple\Client\Response\Pager;

use Xtuple\Client\Response\Pager\Page\Page;

interface Pager {
  public function page(): Page;

  public function total(): int;
}
