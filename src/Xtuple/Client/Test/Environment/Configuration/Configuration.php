<?php declare(strict_types=1);

namespace Xtuple\Client\Test\Environment\Configuration;

use Xtuple\Client\Connection\Connection;

interface Configuration
  extends \Xtuple\Client\Connection\Test\Environment\Configuration\Configuration {
  public function xtuple(): Connection;
}
