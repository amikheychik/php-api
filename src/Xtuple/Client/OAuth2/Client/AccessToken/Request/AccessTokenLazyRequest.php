<?php declare(strict_types=1);

namespace Xtuple\Client\OAuth2\Client\AccessToken\Request;

use Xtuple\Client\Connection\Connection;
use Xtuple\Client\JWT\JWTForConnection;
use Xtuple\Client\OAuth2\Client\AccessToken\Scope\Scope;
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

  /**
   * @throws Throwable
   * @return Request
   */
  protected function request(): Request {
    return new AccessTokenAssertionRequest(
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
}
