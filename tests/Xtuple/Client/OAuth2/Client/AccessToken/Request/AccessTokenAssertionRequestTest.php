<?php declare(strict_types=1);

namespace Xtuple\Client\OAuth2\Client\AccessToken\Request;

use PHPUnit\Framework\TestCase;
use Xtuple\Util\Exception\Exception;
use Xtuple\Util\Exception\Throwable;
use Xtuple\Util\HTTP\Message\Body\String\StringBodyFromBody;
use Xtuple\Util\HTTP\Request\URI\URL\URL;
use Xtuple\Util\HTTP\Request\URI\URL\URLString;
use Xtuple\Util\JWT\Claim\Claim\Header\Algorithm\NoneAlgorithm;
use Xtuple\Util\JWT\Claim\Collection\Map\ArrayMapClaim;
use Xtuple\Util\JWT\Claim\Collection\Map\Header\HeaderMapClaimStruct;
use Xtuple\Util\JWT\Claim\Collection\Map\Payload\PayloadMapClaimStruct;
use Xtuple\Util\JWT\Claim\Collection\Map\Registered\RegisteredMapClaimStruct;
use Xtuple\Util\JWT\JWTStruct;
use Xtuple\Util\OAuth2\Client\Endpoint\Endpoint;
use Xtuple\Util\OAuth2\Client\Endpoint\EndpointStruct;
use Xtuple\Util\Type\DateTime\Timestamp\TimestampNow;

class AccessTokenAssertionRequestTest
  extends TestCase {
  /**
   * @throws \Throwable
   */
  public function testConstructor() {
    $issuedAt = new TimestampNow();
    $request = new AccessTokenAssertionRequest(
      new EndpointStruct(
        new URLString('https://example.com/erp/oauth/v2/token')
      ),
      new JWTStruct(
        new HeaderMapClaimStruct(
          new NoneAlgorithm()
        ),
        new PayloadMapClaimStruct(
          new RegisteredMapClaimStruct(),
          new ArrayMapClaim(),
          new ArrayMapClaim()
        )
      ),
      $issuedAt
    );
    self::assertEquals('POST', (string) $request->method());
    self::assertEquals('https://example.com/erp/oauth/v2/token', $request->uri());
    self::assertEquals($issuedAt->seconds(), $request->issuedAt()->seconds());
    self::assertEquals(1, $request->headers()->count());
    self::assertEquals('application/json', $request->headers()->get('Content-Type')->value());
    self::assertEquals(
      '{"grant_type":"assertion","assertion_type":"assertion","assertion":"eyJ0eXAiOiJKV1QiLCJhbGciOiJub25lIn0.e30"}',
      (string) new StringBodyFromBody($request->body())
    );
  }

  /**
   * @expectedException \Xtuple\Util\Exception\Throwable
   * @expectedExceptionMessage Failed to create an assertion access token request
   * @throws \Throwable
   */
  public function testConstructorException() {
    new AccessTokenAssertionRequest(
      new BrokenEndpoint(),
      new JWTStruct(
        new HeaderMapClaimStruct(
          new NoneAlgorithm()
        ),
        new PayloadMapClaimStruct(
          new RegisteredMapClaimStruct(),
          new ArrayMapClaim(),
          new ArrayMapClaim()
        )
      ),
      new TimestampNow()
    );
  }
}

final class BrokenEndpoint
  implements Endpoint {
  /**
   * @throws Throwable
   */
  public function token(): URL {
    throw new Exception('Endpoint is broken for testing');
  }
}
