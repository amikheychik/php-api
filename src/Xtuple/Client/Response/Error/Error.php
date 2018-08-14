<?php declare(strict_types=1);

namespace Xtuple\Client\Response\Error;

use Xtuple\Util\Type\String\Message\Message\Message;

interface Error
  extends Message {
  public function trigger(): string;

  public function code(): int;
}
