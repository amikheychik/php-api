<?php declare(strict_types=1);

namespace Xtuple\Client\OAuth2\Client\AccessToken\Request;

use Xtuple\Client\Connection\Connection;
use Xtuple\Client\JWT\JWTForConnection;
use Xtuple\Client\OAuth2\Client\AccessToken\Scope\Scope;
use Xtuple\Util\Cache\Key\Key;
use Xtuple\Util\Cache\Key\KeyStruct;
use Xtuple\Util\Exception\Throwable;
use Xtuple\Util\HTTP\Request\AbstractLazyRequest;
use Xtuple\Util\HTTP\Request\Request;
use Xtuple\Util\JWT\Claim\Claim\Registered\Subject\Subject;
use Xtuple\Util\OAuth2\Client\AccessToken\Request\AccessTokenRequest;
use Xtuple\Util\Type\DateTime\Timestamp\Timestamp;

final class AccessTokenLazyRequest
  extends AbstractLazyRequest
  implements AccessTokenRequest {
  /** @var Connection */
  private $connection;
  /** @var Scope */
  private $scope;
  /** @var Subject */
  private $subject;
  /** @var Timestamp */
  private $issuedAt;

  public function __construct(Connection $connection, Scope $scope, Subject $subject, Timestamp $issuedAt) {
    $this->connection = $connection;
    $this->scope = $scope;
    $this->subject = $subject;
    $this->issuedAt = $issuedAt;
  }

  public function issuedAt(): Timestamp {
    return $this->issuedAt;
  }

  public function key(): Key {
    return new KeyStruct([
      (string) $this->connection->token(),
      sha1($this->scope->value()),
      sha1($this->scope->site()),
      sha1((string) $this->subject),
    ]);
  }

  /**
   * @throws Throwable
   * @return Request
   */
  protected function request(): Request {
    return $this->token();
  }

  /** @var array */
  private $tokens = [];

  /**
   * @throws Throwable
   * @return AccessTokenRequest
   */
  private function token(): AccessTokenRequest {
    $key = implode('::', $this->key()->fields());
    if (!isset($this->tokens[$key])) {
      $this->tokens[$key] = new AccessTokenAssertionRequest(
        $this->connection,
        new JWTForConnection(
          $this->connection,
          $this->scope,
          $this->subject,
          $this->issuedAt
        ),
        $this->issuedAt
      );
    }
    return $this->tokens[$key];
  }
}
