<?php declare(strict_types=1);

namespace Xtuple\Client\OAuth2\Client;

use Xtuple\Client\Connection\Connection;
use Xtuple\Client\OAuth2\Client\AccessToken\Request\AccessTokenLazyRequest;
use Xtuple\Client\OAuth2\Client\AccessToken\Scope\Scope;
use Xtuple\Util\Cache\Cache;
use Xtuple\Util\HTTP\Client\CURL\Configuration\DebugConfiguration;
use Xtuple\Util\HTTP\Client\CURL\Configuration\DefaultConfiguration;
use Xtuple\Util\HTTP\Client\CURL\CURLClient;
use Xtuple\Util\JWT\Claim\Claim\Registered\Subject\Subject;
use Xtuple\Util\OAuth2\Client\AbstractClient;
use Xtuple\Util\OAuth2\Client\HTTPClient;
use Xtuple\Util\Type\DateTime\Timestamp\TimestampNow;

final class ClientForConnection
  extends AbstractClient {
  public function __construct(Connection $connection, Cache $tokens, Scope $scope, Subject $subject) {
    parent::__construct(
      new HTTPClient(
        new CURLClient(
          $connection->debug()
            ? new DebugConfiguration()
            : new DefaultConfiguration()
        ),
        $tokens,
        new AccessTokenLazyRequest(
          $connection,
          $scope,
          $subject,
          new TimestampNow()
        )
      )
    );
  }
}
