<?php declare(strict_types=1);

namespace Xtuple\Client\OAuth2\Client\Token\Access\Cache\Key;

use Xtuple\Client\Connection\Connection;
use Xtuple\Client\OAuth2\Client\Token\Scope\Scope;
use Xtuple\Util\Cache\Key\AbstractKey;
use Xtuple\Util\Cache\Key\KeyStruct;
use Xtuple\Util\JWT\Claim\Claim\Registered\Subject\Subject;

final class KeyForConnection
  extends AbstractKey {
  public function __construct(Connection $connection, Subject $subject, Scope $scope) {
    parent::__construct(new KeyStruct([
      (string) $connection->token(),
      sha1($connection->iss()->value()),
      $subject->value(),
      sha1($scope->value()),
    ]));
  }
}
