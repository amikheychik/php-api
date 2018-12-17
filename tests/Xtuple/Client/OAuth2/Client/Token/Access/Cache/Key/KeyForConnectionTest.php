<?php declare(strict_types=1);

namespace Xtuple\Client\OAuth2\Client\Token\Access\Cache\Key;

use PHPUnit\Framework\TestCase;
use Xtuple\Client\Connection\ConnectionStruct;
use Xtuple\Client\JWT\Claim\Claim\Registered\Subject\SubjectForCustomer;
use Xtuple\Client\OAuth2\Client\Token\Scope\ScopeStruct;
use Xtuple\Util\JWT\Claim\Claim\Registered\Issuer\IssuerStruct;

class KeyForConnectionTest
  extends TestCase {
  public function testConstructor() {
    $key = new KeyForConnection(
      new ConnectionStruct('phpunit', 'https://example.com/', 'erp', new IssuerStruct('issuer'), '/tmp/test.p12'),
      new SubjectForCustomer(),
      new ScopeStruct('session')
    );
    self::assertEquals([
      'https://example.com/erp/oauth/v2/token',
      sha1('issuer'),
      'admin',
      sha1('externalId:session customer:GUEST'),
    ], $key->fields());
  }
}
