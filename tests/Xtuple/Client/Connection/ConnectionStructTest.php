<?php declare(strict_types=1);

namespace Xtuple\Client\Connection;

use PHPUnit\Framework\TestCase;
use Xtuple\Util\JWT\Claim\Claim\Registered\Issuer\IssuerStruct;

class ConnectionStructTest
  extends TestCase {
  public function testSerialize() {
    $config = new ConnectionStruct(
      'xdruple',
      'https://example.com',
      'erp',
      new IssuerStruct('mobile'),
      '/var/xtuple/key.p12',
      false
    );
    /** @var TestAbstractConnection $unserialized */
    $unserialized = unserialize(serialize(new TestAbstractConnection($config)));
    self::assertEquals($unserialized->application(), $config->application());
    self::assertEquals('xdruple', $config->application());
    self::assertEquals($unserialized->host(), $config->host());
    self::assertEquals('https://example.com', $config->host());
    self::assertEquals($unserialized->database(), $config->database());
    self::assertEquals('erp', $config->database());
    self::assertEquals($unserialized->iss()->value(), $config->iss()->value());
    self::assertEquals('iss: mobile', (string) $config->iss());
    self::assertEquals($unserialized->discovery(), $config->discovery());
    self::assertEquals('https://example.com/erp/discovery/v1alpha1/apis/v1alpha1/rest', $config->discovery());
    self::assertEquals($unserialized->key(), $config->key());
    self::assertEquals('/var/xtuple/key.p12', $config->key());
    self::assertEquals($unserialized->url(), $config->url());
    self::assertEquals('https://example.com/erp', $config->url());
    self::assertEquals($unserialized->debug(), $config->debug());
    self::assertFalse($config->debug());
    self::assertEquals((string) $unserialized->token(), (string) $config->token());
    self::assertEquals('https://example.com/erp/oauth/v2/token', (string) $config->token());
  }
}

final class TestAbstractConnection
  extends AbstractConnection {
}
