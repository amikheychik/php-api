<?php declare(strict_types=1);

namespace Xtuple\Client\OAuth2\Client\Token\Access\Request;

use Xtuple\Util\Exception\ChainException;
use Xtuple\Util\Exception\Throwable;
use Xtuple\Util\HTTP\Message\Body\String\JSON\JSONBodyData;
use Xtuple\Util\HTTP\Request\AbstractRequest;
use Xtuple\Util\HTTP\Request\Request\JSON\POSTJSONRequest;
use Xtuple\Util\JWT\JWT;
use Xtuple\Util\OAuth2\Client\Endpoint\Endpoint;

final class AssertionRequest
  extends AbstractRequest {
  /**
   * @throws Throwable
   *
   * @param Endpoint $endpoint
   * @param JWT      $jwt
   */
  public function __construct(Endpoint $endpoint, JWT $jwt) {
    try {
      parent::__construct(new POSTJSONRequest(
        $endpoint->token(),
        new JSONBodyData([
          'grant_type' => 'assertion',
          'assertion_type' => 'assertion',
          'assertion' => $jwt->encoded(),
        ])
      ));
    }
    catch (\Throwable $e) {
      throw new ChainException($e, 'Failed to build assertion request');
    }
  }
}
