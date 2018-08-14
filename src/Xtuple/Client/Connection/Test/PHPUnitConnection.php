<?php declare(strict_types=1);

namespace Xtuple\Client\Connection\Test;

use Xtuple\Client\Connection\AbstractConnection;
use Xtuple\Client\Connection\ConnectionStruct;
use Xtuple\Util\JWT\Claim\Claim\Registered\Issuer\IssuerStruct;

final class PHPUnitConnection
  extends AbstractConnection {
  public function __construct(string $key) {
    parent::__construct(new ConnectionStruct(
      'phpunit',
      'https://example.com',
      'erp',
      new IssuerStruct('test'),
      $key,
      true
    ));
  }
}
