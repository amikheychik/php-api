<?php declare(strict_types=1);

namespace Xtuple\Client\Connection;

use PHPUnit\Framework\TestCase;

class ConnectionArrayTest
  extends TestCase {
  public function testSerialize() {
    $config = new ConnectionArray([
      'application' => 'xdruple',
      'host' => 'http://example.com',
      'database' => 'erp',
      'iss' => 'mobile',
      'key' => '/var/xtuple/key.p12',
      'debug' => false,
    ]);
    /** @var ConnectionArray $unserialized */
    $unserialized = unserialize(serialize($config));
    self::assertEquals($unserialized->application(), $config->application());
    self::assertEquals($unserialized->host(), $config->host());
    self::assertEquals($unserialized->database(), $config->database());
    self::assertEquals($unserialized->iss()->value(), $config->iss()->value());
    self::assertEquals($unserialized->discovery(), $config->discovery());
    self::assertEquals($unserialized->key(), $config->key());
    self::assertEquals($unserialized->url(), $config->url());
    self::assertEquals($unserialized->debug(), $config->debug());
    self::assertEquals((string) $unserialized->token(), (string) $config->token());
  }
}

final class TestLazyConnection
  extends AbstractLazyConnection {
  /** @var array */
  private $connection;

  public function __construct(array $connection) {
    $this->connection = $connection;
  }

  protected function connection(): Connection {
    return new ConnectionArray($this->connection);
  }

  public function serialize() {
    return serialize($this->connection);
  }

  public function unserialize($serialized) {
    $this->connection = unserialize($serialized, ['allowed_classes' => false]);
  }
}
