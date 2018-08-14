<?php declare(strict_types=1);

namespace Xtuple\Client\Connection;

use Xtuple\Util\HTTP\Request\URI\URL\URL;
use Xtuple\Util\JWT\Claim\Claim\Registered\Issuer\Issuer;
use Xtuple\Util\OAuth2\Client\Endpoint\Endpoint;

interface Connection
  extends Endpoint,
          \Serializable {
  public function application(): string;

  public function host(): string;

  public function url(): string;

  public function database(): string;

  public function discovery(): string;

  public function token(): URL;

  public function iss(): Issuer;

  public function key(): string;

  public function debug(): bool;
}
