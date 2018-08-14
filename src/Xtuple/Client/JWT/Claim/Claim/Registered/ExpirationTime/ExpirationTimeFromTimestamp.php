<?php declare(strict_types=1);

namespace Xtuple\Client\JWT\Claim\Claim\Registered\ExpirationTime;

use Xtuple\Util\JWT\Claim\Claim\Registered\ExpirationTime\AbstractExpirationTime;
use Xtuple\Util\JWT\Claim\Claim\Registered\ExpirationTime\LifetimeExpirationTimeFromTimestamp;
use Xtuple\Util\Type\DateTime\Timestamp\Timestamp;

/**
 * Lifetime is hardcoded in the API
 */
final class ExpirationTimeFromTimestamp
  extends AbstractExpirationTime {
  public function __construct(Timestamp $issuedAt) {
    parent::__construct(new LifetimeExpirationTimeFromTimestamp($issuedAt, 3600));
  }
}
