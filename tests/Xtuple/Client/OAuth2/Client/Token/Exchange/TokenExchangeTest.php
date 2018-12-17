<?php declare(strict_types=1);

namespace Xtuple\Client\OAuth2\Client\Token\Exchange;

use Xtuple\Client\Connection\Test\PHPUnitConnection;
use Xtuple\Client\JWT\Claim\Claim\Header\Algorithm\Test\AlgorithmTestCase;
use Xtuple\Client\JWT\Claim\Claim\Registered\Subject\SubjectForCustomer;
use Xtuple\Client\OAuth2\Client\Token\Access\Cache\Key\KeyForConnection;
use Xtuple\Client\OAuth2\Client\Token\Scope\ScopeStruct;
use Xtuple\Util\Cache\Cache\Memory\MemoryCache;
use Xtuple\Util\Cache\Record\RecordStruct;
use Xtuple\Util\HTTP\Client\Test\TestClient;
use Xtuple\Util\OAuth2\Client\Token\Access\AccessTokenStruct;
use Xtuple\Util\Type\DateTime\Timestamp\TimestampNow;
use Xtuple\Util\Type\DateTime\Timestamp\TimestampStruct;
use Xtuple\Util\Type\UUID\UUIDv4;

class TokenExchangeTest
  extends AlgorithmTestCase {
  /**
   * @throws \Throwable
   */
  public function testExpiredToken() {
    $tokens = new MemoryCache('phpunit');
    $connection = new PHPUnitConnection($this->p12);
    $scope = new ScopeStruct('session');
    $subject = new SubjectForCustomer();
    $now = new TimestampNow();
    $exchange = new TokenExchange(
      new TestClient(),
      $tokens,
      $connection,
      $scope,
      $subject,
      $now
    );
    $token = (string) new UUIDv4();
    $tokens->insert(new RecordStruct(
      new KeyForConnection($connection, $subject, $scope),
      new AccessTokenStruct($token, 'Bearer', new TimestampStruct($now->seconds() - 3600), null)
    ));
    self::assertNotEquals($token, $exchange->token()->value());
  }
}
