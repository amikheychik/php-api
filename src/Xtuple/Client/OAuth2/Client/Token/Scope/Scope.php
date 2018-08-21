<?php declare(strict_types=1);

namespace Xtuple\Client\OAuth2\Client\Token\Scope;

use Xtuple\Util\OAuth2\Client\Token\Scope\Scope as AccessTokenScope;

interface Scope
  extends AccessTokenScope {
  public function site(): string;
}
