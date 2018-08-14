<?php declare(strict_types=1);

namespace Xtuple\Client\Test\Environment;

use Xtuple\Client\Client;
use Xtuple\Client\Connection\Connection;

interface Environment {
  public function connection(): Connection;

  public function client(): Client;
}
