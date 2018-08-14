<?php declare(strict_types=1);

namespace Xtuple\Client\JWT;

use Xtuple\Client\Connection\Connection;
use Xtuple\Client\JWT\Claim\Claim\Header\Algorithm\Algorithm;
use Xtuple\Client\JWT\Claim\Claim\Registered\ExpirationTime\ExpirationTimeFromTimestamp;
use Xtuple\Client\OAuth2\Client\AccessToken\Scope\Scope;
use Xtuple\Util\Exception\ChainException;
use Xtuple\Util\JWT\AbstractLazyJWT;
use Xtuple\Util\JWT\Claim\Claim\Registered\Audience\AudienceStruct;
use Xtuple\Util\JWT\Claim\Claim\Registered\IssuedAt\IssuedAtTimestamp;
use Xtuple\Util\JWT\Claim\Claim\Registered\Subject\Subject;
use Xtuple\Util\JWT\Claim\ClaimStruct;
use Xtuple\Util\JWT\Claim\Collection\Map\ArrayMapClaim;
use Xtuple\Util\JWT\Claim\Collection\Map\Header\HeaderMapClaim;
use Xtuple\Util\JWT\Claim\Collection\Map\Header\HeaderMapClaimStruct;
use Xtuple\Util\JWT\Claim\Collection\Map\Payload\PayloadMapClaim;
use Xtuple\Util\JWT\Claim\Collection\Map\Payload\PayloadMapClaimStruct;
use Xtuple\Util\JWT\Claim\Collection\Map\Registered\RegisteredMapClaimStruct;
use Xtuple\Util\Type\DateTime\Timestamp\Timestamp;

final class JWTForConnection
  extends AbstractLazyJWT {
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

  public function header(): HeaderMapClaim {
    return new HeaderMapClaimStruct(
      new Algorithm($this->connection->key())
    );
  }

  public function payload(): PayloadMapClaim {
    try {
      return new PayloadMapClaimStruct(
        new RegisteredMapClaimStruct(
          $this->connection->iss(),
          $this->subject,
          new AudienceStruct((string) $this->connection->token()),
          new IssuedAtTimestamp($this->issuedAt),
          new ExpirationTimeFromTimestamp($this->issuedAt),
          null,
          null
        ),
        new ArrayMapClaim(),
        new ArrayMapClaim([
          new ClaimStruct('scope', $this->scope->value()),
          new ClaimStruct('prn', $this->subject->value()),
        ])
      );
    }
    catch (\Throwable $e) {
      throw new ChainException($e, 'Failed to define JWT claim payload');
    }
  }
}
