<?php declare(strict_types=1);

namespace Xtuple\Client\OAuth2\Client\AccessToken\Scope;

use Xtuple\Util\OAuth2\Client\AccessToken\Scope\Scope as AccessTokenScope;

interface Scope
  extends AccessTokenScope {
  public function site(): string;
}
