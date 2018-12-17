<?php declare(strict_types=1);

namespace Xtuple\Client\OAuth2\Client\Token\Scope;

use Xtuple\Util\OAuth2\Client\Token\Scope\AbstractScope;
use Xtuple\Util\OAuth2\Client\Token\Scope\ScopeStruct as AccessTokenScopeStruct;

final class ScopeStruct
  extends AbstractScope
  implements Scope {
  /** @var string */
  private $site;

  public function __construct(string $externalId, string $customer = 'GUEST', string $shipTo = '', string $site = '') {
    $scope = array_filter(compact('externalId', 'customer', 'shipTo', 'site'));
    foreach ($scope as $key => $value) {
      $scope[$key] = "{$key}:{$value}";
    }
    parent::__construct(new AccessTokenScopeStruct(
      implode(' ', $scope)
    ));
    $this->site = $site;
  }

  public function site(): string {
    return $this->site;
  }
}
