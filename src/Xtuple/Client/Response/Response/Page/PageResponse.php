<?php declare(strict_types=1);

namespace Xtuple\Client\Response\Response\Page;

use Xtuple\Client\Response\Pager\Pager;
use Xtuple\Client\Response\Response;

interface PageResponse
  extends Response {
  public function data(): array;

  public function etags(): array;

  public function pager(): Pager;
}
