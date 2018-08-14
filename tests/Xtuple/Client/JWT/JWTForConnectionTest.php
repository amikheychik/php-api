<?php declare(strict_types=1);

namespace Xtuple\Client\JWT;

use Xtuple\Client\Connection\AbstractLazyConnection;
use Xtuple\Client\Connection\Connection;
use Xtuple\Client\Connection\Test\PHPUnitConnection;
use Xtuple\Client\JWT\Claim\Claim\Header\Algorithm\Test\AlgorithmTestCase;
use Xtuple\Client\JWT\Claim\Claim\Registered\Subject\SubjectForCustomer;
use Xtuple\Client\OAuth2\Client\AccessToken\Scope\ScopeStruct;
use Xtuple\Util\Exception\Exception;
use Xtuple\Util\Exception\Throwable;
use Xtuple\Util\Type\DateTime\Timestamp\TimestampNow;
use Xtuple\Util\Type\DateTime\Timestamp\TimestampStruct;

class JWTForConnectionTest
  extends AlgorithmTestCase {
  /**
   * @throws \Throwable
   */
  public function testConstructor() {
    $connection = new PHPUnitConnection($this->p12);
    $scope = new ScopeStruct('erp', '05098435b82fa53ab8dc5a713ca1f43a93c7685c');
    $subject = new SubjectForCustomer('GUEST');
    $issuedAt = new TimestampStruct(1534192554);
    $jwt = new JWTForConnection($connection, $scope, $subject, $issuedAt);
    self::assertEquals(2, $jwt->header()->count());
    self::assertEquals('RS256', $jwt->header()->get('alg')->value());
    self::assertEquals('JWT', $jwt->header()->get('typ')->value());
    self::assertEquals(7, $jwt->payload()->count());
    self::assertEquals('test', $jwt->payload()->get('iss')->value());
    self::assertEquals('guest', $jwt->payload()->get('sub')->value());
    self::assertEquals('https://example.com/erp/oauth/v2/token', $jwt->payload()->get('aud')->value());
    self::assertEquals(1534192554, $jwt->payload()->get('iat')->value());
    self::assertEquals(1534196154, $jwt->payload()->get('exp')->value());
    self::assertEquals(
      implode(' ', [
        'erp.session.externalId:05098435b82fa53ab8dc5a713ca1f43a93c7685c',
        'erp.session.customer:GUEST',
      ]),
      $jwt->payload()->get('scope')->value()
    );
    self::assertEquals('guest', $jwt->payload()->get('prn')->value());
    /** @noinspection SpellCheckingInspection */
    self::assertEquals(implode('', [
      'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.',
      'eyJpc3MiOiJ0ZXN0Iiwic3ViIjoiZ3Vlc3QiLCJhdWQiOiJodHRwczovL2V4YW1wbGUuY29tL2Vyc',
      'C9vYXV0aC92Mi90b2tlbiIsImlhdCI6MTUzNDE5MjU1NCwiZXhwIjoxNTM0MTk2MTU0LCJzY29wZS',
      'I6ImVycC5zZXNzaW9uLmV4dGVybmFsSWQ6MDUwOTg0MzViODJmYTUzYWI4ZGM1YTcxM2NhMWY0M2E',
      '5M2M3Njg1YyBlcnAuc2Vzc2lvbi5jdXN0b21lcjpHVUVTVCIsInBybiI6Imd1ZXN0In0.',
      'rgOHMc2yuCFUCP74EOresj8P_0-I-4CLDNx9bEwuC7DXnQULHxEYqDdhpvbLY-gVbu3hipqB1Ajkv',
      'm0FMXHghUbXXcNVsiMCnYfeFaBwzDBnYJANvMk8-sGm0kW8Hk8u5Mr59UJ__Kaug-nQKJ-5V-XiCF',
      'JCRoSmW-ilmt8b6Qk',
    ]), $jwt->encoded());
  }

  /**
   * @expectedException \Xtuple\Util\Exception\Throwable
   * @expectedExceptionMessage Failed to define JWT claim payload
   * @throws \Throwable
   */
  public function testPayloadException() {
    $jwt = new JWTForConnection(
      new WrongConnection(),
      new ScopeStruct('erp', 'session'),
      new SubjectForCustomer('GUEST'),
      new TimestampNow()
    );
    $jwt->payload();
  }
}

final class WrongConnection
  extends AbstractLazyConnection {
  /**
   * @throws Throwable
   * @return Connection
   */
  protected function connection(): Connection {
    throw new Exception('Failed to read connection info');
  }

  public function serialize() {
  }

  public function unserialize($serialized) {
  }
}
