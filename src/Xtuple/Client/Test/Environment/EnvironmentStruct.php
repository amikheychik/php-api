<?php declare(strict_types=1);

namespace Xtuple\Client\Test\Environment;

use Xtuple\Client\Client;
use Xtuple\Client\Connection\Connection;
use Xtuple\Client\Connection\Test\Environment\Configuration\Configuration;
use Xtuple\Client\ERPClient;
use Xtuple\Client\JWT\Claim\Claim\Registered\Subject\SubjectForCustomer;
use Xtuple\Client\OAuth2\Client\Token\Scope\ScopeStruct;
use Xtuple\Util\Cache\Cache\Memory\MemoryCache;

final class EnvironmentStruct
  implements Environment {
  /** @var Connection */
  private $connection;
  /** @var Client */
  private $client;

  /**
   * @throws \Throwable
   *
   * @param Configuration $environment
   */
  public function __construct(Configuration $environment) {
    $this->connection = $environment->xtuple();
    $this->client = new ERPClient(
      $environment->xtuple(),
      new MemoryCache('oauth'),
      new SubjectForCustomer(),
      new ScopeStruct(
        md5((string) random_int(0, PHP_INT_MAX))
      )
    );
  }

  public function connection(): Connection {
    return $this->connection;
  }

  public function client(): Client {
    return $this->client;
  }
}
