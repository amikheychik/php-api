<?php declare(strict_types=1);

namespace Xtuple\Client\Connection;

use PHPUnit\Framework\TestCase;
use Xtuple\Util\XML\Element\XMLElementString;

class ConnectionXMLElementTest
  extends TestCase {
  /**
   * @throws \Throwable
   */
  public function testConstructor() {
    $element = new XMLElementString(implode(' ', [
      '<xtuple host="https://example.com"',
      'database="erp"',
      'iss="test"',
      'key="/tmp/phpunit/php-api/pkcs12/jwt-io.p12"',
      'application="phpunit"',
      'debug="true"',
      '/>',
    ]));
    $connection = new ConnectionXMLElement($element);
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
