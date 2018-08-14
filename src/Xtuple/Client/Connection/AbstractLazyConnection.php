<?php declare(strict_types=1);

namespace Xtuple\Client\Connection;

use Xtuple\Util\HTTP\Request\URI\URL\URL;
use Xtuple\Util\JWT\Claim\Claim\Registered\Issuer\Issuer;

abstract class AbstractLazyConnection
  implements Connection {
  protected abstract function connection(): Connection;

  public final function application(): string {
    return $this->connection()->application();
  }

  public final function host(): string {
    return $this->connection()->host();
  }

  public final function url(): string {
    return $this->connection()->url();
  }

  public final function database(): string {
    return $this->connection()->database();
  }

  public final function discovery(): string {
    return $this->connection()->discovery();
  }

  public final function token(): URL {
    return $this->connection()->token();
  }

  public final function iss(): Issuer {
    return $this->connection()->iss();
  }

  public final function key(): string {
    return $this->connection()->key();
  }

  public final function debug(): bool {
    return $this->connection()->debug();
  }
}
