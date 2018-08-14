<?php declare(strict_types=1);

namespace Xtuple\Client\Connection;

use Xtuple\Util\JWT\Claim\Claim\Registered\Issuer\IssuerStruct;

final class ConnectionArray
  extends AbstractLazyConnection {
  /** @var array */
  private $connection;

  public function __construct(array $connection) {
    $this->connection = $connection;
  }

  public function serialize() {
    return serialize($this->connection);
  }

  public function unserialize($serialized) {
    $this->connection = unserialize($serialized, ['allowed_classes' => true]);
  }

  /** @var Connection|null */
  private $configuration;

  protected function connection(): Connection {
    if ($this->configuration === null) {
      $this->configuration = new ConnectionStruct(
        $this->connection['application'],
        $this->connection['host'],
        $this->connection['database'],
        new IssuerStruct($this->connection['iss']),
        $this->connection['key'],
        $this->connection['debug']
      );
    }
    return $this->configuration;
  }
}
