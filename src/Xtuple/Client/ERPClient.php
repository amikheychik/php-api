<?php declare(strict_types=1);

namespace Xtuple\Client;

use Xtuple\Client\Connection\Connection;
use Xtuple\Client\OAuth2\Client\ClientForConnection;
use Xtuple\Client\OAuth2\Client\Token\Scope\Scope;
use Xtuple\Client\Request\Collection\Map\MapRequest;
use Xtuple\Client\Request\Request;
use Xtuple\Client\Result\Collection\Map\MapResult;
use Xtuple\Client\Result\Collection\Map\MapResultFromMapHTTPResult;
use Xtuple\Client\Result\Result;
use Xtuple\Client\Result\ResultFromHTTPResult;
use Xtuple\Util\Cache\Cache;
use Xtuple\Util\Exception\ExceptionWithArguments;
use Xtuple\Util\JWT\Claim\Claim\Registered\Subject\Subject;
use Xtuple\Util\OAuth2\Client\Client as OAuth2Client;
use Xtuple\Util\Type\String\Message\Argument\Collection\Map\ArrayMapArgument;
use Xtuple\Util\Type\String\Message\Type\Plural\PluralArgumentFromStrings;

final class ERPClient
  implements Client {
  /** @var Connection */
  private $connection;
  /** @var Cache */
  private $tokensStorage;
  /** @var Subject */
  private $subject;
  /** @var Scope */
  private $scope;

  public function __construct(Connection $connection, Cache $tokensStorage, Subject $subject, Scope $scope) {
    $this->connection = $connection;
    $this->tokensStorage = $tokensStorage;
    $this->subject = $subject;
    $this->scope = $scope;
  }

  public function send(Request $request): Result {
    return new ResultFromHTTPResult($this->oauth2()->send($request));
  }

  public function sendMany(MapRequest $requests): MapResult {
    try {
      return new MapResultFromMapHTTPResult($this->oauth2()->sendMany($requests));
    }
    catch (\Throwable $e) {
      throw new ExceptionWithArguments('HTTP {request} failed', new ArrayMapArgument([
        new PluralArgumentFromStrings('request', count($requests), 'requests', 'request'),
      ]), $e);
    }
  }

  /** @var null|OAuth2Client */
  private $oAuth2;

  private function oauth2(): OAuth2Client {
    if ($this->oAuth2 === null) {
      $this->oAuth2 = new ClientForConnection(
        $this->connection,
        $this->tokensStorage,
        $this->scope,
        $this->subject
      );
    }
    return $this->oAuth2;
  }
}
