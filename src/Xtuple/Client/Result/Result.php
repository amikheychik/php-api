<?php declare(strict_types=1);

namespace Xtuple\Client\Result;

use Xtuple\Client\Response\Response;
use Xtuple\Util\Exception\Throwable;

interface Result {
  public function key(): string;

  /**
   * @throws Throwable
   * @return Response
   */
  public function response(): Response;
}
