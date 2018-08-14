<?php declare(strict_types=1);

namespace Xtuple\Client\OAuth2\Client\AccessToken\Scope;

use Xtuple\Util\OAuth2\Client\AccessToken\Scope\AbstractScope;
use Xtuple\Util\OAuth2\Client\AccessToken\Scope\ScopeStruct as AccessTokenScopeStruct;

final class ScopeStruct
  extends AbstractScope
  implements Scope {
  /** @var string */
  private $site;

  public function __construct(string $database, string $externalId, string $customer = 'GUEST', string $shipTo = '',
                              string $site = '') {
    $scope = compact('externalId', 'customer', 'shipTo', 'site');
    foreach (array_filter($scope) as $key => $value) {
      $scope[$key] = "{$database}.session.{$key}:{$value}";
    }
    parent::__construct(new AccessTokenScopeStruct(
      implode(' ', array_filter($scope))
    ));
    $this->site = $site;
  }

  public function site(): string {
    return $this->site;
  }
}
