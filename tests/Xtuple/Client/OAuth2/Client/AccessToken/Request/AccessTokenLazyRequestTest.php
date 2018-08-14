<?php declare(strict_types=1);

namespace Xtuple\Client\OAuth2\Client\AccessToken\Request;

use Xtuple\Client\Connection\Test\PHPUnitConnection;
use Xtuple\Client\JWT\Claim\Claim\Header\Algorithm\Test\AlgorithmTestCase;
use Xtuple\Client\JWT\Claim\Claim\Registered\Subject\SubjectForCustomer;
use Xtuple\Client\OAuth2\Client\AccessToken\Scope\ScopeStruct;
use Xtuple\Util\Type\DateTime\Timestamp\TimestampNow;

class AccessTokenLazyRequestTest
  extends AlgorithmTestCase {
  public function testConstructor() {
    $now = new TimestampNow();
    $request = new AccessTokenLazyRequest(
      new PHPUnitConnection($this->p12),
      new ScopeStruct('erp', 'session'),
      new SubjectForCustomer(),
      $now
    );
    self::assertEquals($now->seconds(), $request->issuedAt()->seconds());
    self::assertEquals('https://example.com/erp/oauth/v2/token', (string) $request->uri());
  }
}
