<?php declare(strict_types=1);

namespace Xtuple\Client\OAuth2\Client\Token\Access;

use Xtuple\Util\Exception\ChainException;
use Xtuple\Util\Exception\Exception;
use Xtuple\Util\Exception\Throwable;
use Xtuple\Util\HTTP\Response\JSON\JSONResponseStruct;
use Xtuple\Util\HTTP\Response\Response;
use Xtuple\Util\OAuth2\Client\Token\Access\AbstractAccessToken;
use Xtuple\Util\OAuth2\Client\Token\Access\AccessTokenStruct;
use Xtuple\Util\Type\DateTime\Timestamp\Timestamp;
use Xtuple\Util\Type\DateTime\Timestamp\TimestampStruct;

final class AccessTokenFromResponse
  extends AbstractAccessToken {
  /**
   * @throws Throwable
   *
   * @param Response  $response
   * @param Timestamp $now
   */
  public function __construct(Response $response, Timestamp $now) {
    if ($response->status()->code() !== 200) {
      throw new Exception('Access token request failed: {status}', [
        'status' => $response->status(),
      ]);
    }
    try {
      $data = (new JSONResponseStruct($response))->json();
      parent::__construct(new AccessTokenStruct(
        (string) $data->get(['access_token']),
        (string) $data->get(['token_type']),
        new TimestampStruct($now->seconds() + (int) $data->get(['expires_in'])),
        null
      ));
    }
    catch (\Throwable $e) {
      throw new ChainException($e, 'Failed to parse access token response');
    }
  }
}
