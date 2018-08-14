<?php declare(strict_types=1);

namespace Xtuple\Client\Connection\Test;

use PHPUnit\Framework\TestCase;

class PHPUnitConnectionTest
  extends TestCase {
  public function testConstructor() {
    $connection = new PHPUnitConnection('/tmp/phpunit/php-api/pkcs12/jwt-io.p12');
    self::assertEquals('phpunit', $connection->application());
    self::assertEquals('https://example.com', $connection->host());
    self::assertEquals('erp', $connection->database());
    self::assertEquals('iss: test', (string) $connection->iss());
    self::assertEquals('https://example.com/erp/discovery/v1alpha1/apis/v1alpha1/rest', $connection->discovery());
    self::assertEquals('/tmp/phpunit/php-api/pkcs12/jwt-io.p12', $connection->key());
    self::assertEquals('https://example.com/erp', $connection->url());
    self::assertTrue($connection->debug());
    self::assertEquals('https://example.com/erp/oauth/v2/token', (string) $connection->token());
  }
}
