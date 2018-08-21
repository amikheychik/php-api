<?php declare(strict_types=1);

namespace Xtuple\Client\OAuth2\Client\Token\Access;

use PHPUnit\Framework\TestCase;
use Xtuple\Util\HTTP\Message\Body\String\JSON\JSONBodyData;
use Xtuple\Util\HTTP\Message\Body\String\StringBodyFromString;
use Xtuple\Util\HTTP\Message\Header\Collection\Set\ArraySetHeader;
use Xtuple\Util\HTTP\Response\JSON\JSONResponseStruct;
use Xtuple\Util\HTTP\Response\ResponseStruct;
use Xtuple\Util\HTTP\Response\Status\StatusString;
use Xtuple\Util\Type\DateTime\Timestamp\TimestampNow;
use Xtuple\Util\Type\UUID\UUIDv4;

class AccessTokenFromResponseTest
  extends TestCase {
  /**
   * @throws \Throwable
   */
  public function testConstructor() {
    $token = (string) new UUIDv4();
    $response = new JSONResponseStruct(new ResponseStruct(
      new StatusString('HTTP/1.1 200 OK'),
      new ArraySetHeader(),
      new JSONBodyData([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => 3600,
      ])
    ));
    $now = new TimestampNow();
    $accessToken = new AccessTokenFromResponse($response, $now);
    self::assertEquals($token, $accessToken->value());
    self::assertEquals('bearer', $accessToken->type());
    self::assertNull($accessToken->refresh());
    self::assertEquals($now->seconds() + 3600, $accessToken->expiresAt()->seconds());
  }

  /**
   * @expectedException \Xtuple\Util\Exception\Throwable
   * @expectedExceptionMessage Failed to parse access token response
   * @throws \Throwable
   */
  public function testConstructorException() {
    $now = new TimestampNow();
    $response = new JSONResponseStruct(
      new ResponseStruct(
        new StatusString('HTTP/1.1 200 OK'),
        new ArraySetHeader(),
        new StringBodyFromString('{parsing:exception}')
      )
    );
    new AccessTokenFromResponse($response, $now);
  }
}
