<?php declare(strict_types=1);

namespace Xtuple\Client\OAuth2\Client\Token\Access\Request;

use Xtuple\Client\Connection\Test\PHPUnitConnection;
use Xtuple\Client\JWT\Claim\Claim\Header\Algorithm\Test\AlgorithmTestCase;
use Xtuple\Client\JWT\Claim\Claim\Registered\Subject\SubjectForCustomer;
use Xtuple\Client\JWT\JWTForConnection;
use Xtuple\Client\OAuth2\Client\Token\Scope\ScopeStruct;
use Xtuple\Util\Exception\Exception;
use Xtuple\Util\HTTP\Request\URI\URL\URLString;
use Xtuple\Util\JWT\Claim\Collection\Map\ArrayMapClaim;
use Xtuple\Util\JWT\Claim\Collection\Map\Header\HeaderMapClaim;
use Xtuple\Util\JWT\Claim\Collection\Map\Header\HeaderMapClaimStruct;
use Xtuple\Util\JWT\Claim\Collection\Map\Payload\PayloadMapClaim;
use Xtuple\Util\JWT\Claim\Collection\Map\Payload\PayloadMapClaimStruct;
use Xtuple\Util\JWT\Claim\Collection\Map\Registered\RegisteredMapClaimStruct;
use Xtuple\Util\JWT\JWT;
use Xtuple\Util\OAuth2\Client\Endpoint\EndpointStruct;
use Xtuple\Util\Type\DateTime\Timestamp\TimestampNow;

class AssertionRequestTest
  extends AlgorithmTestCase {
  /**
   * @throws \Throwable
   */
  public function testConstructor() {
    $request = new AssertionRequest(
      new EndpointStruct(
        new URLString('https://example.com/')
      ),
      new JWTForConnection(
        new PHPUnitConnection($this->p12),
        new ScopeStruct('erp', 'phpunit'),
        new SubjectForCustomer(),
        new TimestampNow()
      )
    );
    self::assertEquals('POST', (string) $request->method());
    self::assertEquals('https://example.com/', (string) $request->uri());
    self::assertEquals('application/json', $request->headers()->get('Content-Type')->value());
  }

  /**
   * @expectedException \Xtuple\Util\Exception\Throwable
   * @expectedExceptionMessage Failed to build assertion request
   * @throws \Throwable
   */
  public function testConstructorException() {
    new AssertionRequest(
      new EndpointStruct(
        new URLString('https://example.com/')
      ),
      new BrokenJWT()
    );
  }
}

final class BrokenJWT
  implements JWT {
  public function encoded(): string {
    throw new Exception('JWT is broken for testing');
  }

  public function header(): HeaderMapClaim {
    return new HeaderMapClaimStruct();
  }

  public function payload(): PayloadMapClaim {
    /** @noinspection PhpUnhandledExceptionInspection */
    return new PayloadMapClaimStruct(
      new RegisteredMapClaimStruct(),
      new ArrayMapClaim(),
      new ArrayMapClaim()
    );
  }
}
