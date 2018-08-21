<?php declare(strict_types=1);

namespace Xtuple\Client\OAuth2\Client\Token\Access;

use Xtuple\Client\OAuth2\Client\Token\Access\Request\AssertionRequest;
use Xtuple\Util\Exception\ChainException;
use Xtuple\Util\Exception\Throwable;
use Xtuple\Util\HTTP\Client\Client;
use Xtuple\Util\JWT\JWT;
use Xtuple\Util\OAuth2\Client\Endpoint\Endpoint;
use Xtuple\Util\OAuth2\Client\Token\Access\AbstractAccessToken;
use Xtuple\Util\Type\DateTime\Timestamp\Timestamp;

final class RequestAccessTokenForJWT
  extends AbstractAccessToken {
  /**
   * @throws Throwable
   *
   * @param Client    $http
   * @param Endpoint  $endpoint
   * @param JWT       $jwt
   * @param Timestamp $now
   */
  public function __construct(Client $http, Endpoint $endpoint, JWT $jwt, Timestamp $now) {
    try {
      parent::__construct(new AccessTokenFromResponse($http->send(
        new AssertionRequest($endpoint, $jwt)
      )->response(), $now));
    }
    catch (\Throwable $e) {
      throw new ChainException($e, 'Failed to request an access token for JWT');
    }
  }
}
