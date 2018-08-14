<?php declare(strict_types=1);

namespace Xtuple\Client\OAuth2\Client\AccessToken\Request;

use Xtuple\Util\Exception\ChainException;
use Xtuple\Util\Exception\Throwable;
use Xtuple\Util\HTTP\Message\Body\String\JSON\JSONBodyData;
use Xtuple\Util\HTTP\Request\AbstractRequest;
use Xtuple\Util\JWT\JWT;
use Xtuple\Util\OAuth2\Client\AccessToken\Request\AccessTokenRequest;
use Xtuple\Util\OAuth2\Client\AccessToken\Request\JSON\AccessTokenJSONRequest;
use Xtuple\Util\OAuth2\Client\Endpoint\Endpoint;
use Xtuple\Util\Type\DateTime\Timestamp\Timestamp;

final class AccessTokenAssertionRequest
  extends AbstractRequest
  implements AccessTokenRequest {
  /** @var AccessTokenRequest */
  private $request;

  /**
   * @throws Throwable
   *
   * @param Endpoint  $endpoint
   * @param JWT       $jwt
   * @param Timestamp $issuedAt
   */
  public function __construct(Endpoint $endpoint, JWT $jwt, Timestamp $issuedAt) {
    try {
      $this->request = new AccessTokenJSONRequest($endpoint, new JSONBodyData([
        'grant_type' => 'assertion',
        'assertion_type' => 'assertion',
        'assertion' => $jwt->encoded(),
      ]), $issuedAt);
      parent::__construct($this->request);
    }
    catch (\Throwable $e) {
      throw new ChainException($e, 'Failed to create an assertion access token request');
    }
  }

  public function issuedAt(): Timestamp {
    return $this->request->issuedAt();
  }
}
