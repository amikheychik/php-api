<?php declare(strict_types=1);

namespace Xtuple\Client\OAuth2\Client\Token\Exchange;

use Xtuple\Client\Connection\Connection;
use Xtuple\Client\JWT\JWTForConnection;
use Xtuple\Client\OAuth2\Client\Token\Access\Cache\Key\KeyForConnection;
use Xtuple\Client\OAuth2\Client\Token\Access\RequestAccessTokenForJWT;
use Xtuple\Client\OAuth2\Client\Token\Scope\Scope;
use Xtuple\Util\Cache\Cache;
use Xtuple\Util\Cache\Record\RecordStruct;
use Xtuple\Util\HTTP\Client\Client;
use Xtuple\Util\JWT\Claim\Claim\Registered\Subject\Subject;
use Xtuple\Util\OAuth2\Client\Token\Access\AccessToken;
use Xtuple\Util\OAuth2\Client\Token\Exchange\Exchange;
use Xtuple\Util\Type\DateTime\Timestamp\Timestamp;

final class TokenExchange
  implements Exchange {
  /** @var Client */
  private $http;
  /** @var Cache */
  private $tokens;
  /** @var Connection */
  private $connection;
  /** @var Scope */
  private $scope;
  /** @var Subject */
  private $subject;
  /** @var Timestamp */
  private $now;

  public function __construct(Client $http, Cache $tokens, Connection $connection, Scope $scope, Subject $subject,
                              Timestamp $now) {
    $this->http = $http;
    $this->tokens = $tokens;
    $this->connection = $connection;
    $this->scope = $scope;
    $this->subject = $subject;
    $this->now = $now;
  }

  /**
   * @throws \Throwable
   * @return AccessToken
   */
  public function token(): AccessToken {
    $key = new KeyForConnection($this->connection, $this->subject, $this->scope);
    if (($record = $this->tokens->find($key))
      && ($token = $record->value())
    ) {
      if (!($token instanceof AccessToken)
        || $token->expiresAt()->seconds() < time()) {
        $this->tokens->delete($key);
        $token = null;
      }
    }
    if (!isset($token)) {
      $token = new RequestAccessTokenForJWT($this->http, $this->connection, new JWTForConnection(
        $this->connection,
        $this->scope,
        $this->subject,
        $this->now
      ), $this->now);
      $this->tokens->insert(new RecordStruct($key, $token));
    }
    return $token;
  }
}
