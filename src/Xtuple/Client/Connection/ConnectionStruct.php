<?php declare(strict_types=1);

namespace Xtuple\Client\Connection;

use Xtuple\Util\HTTP\Request\URI\URL\URL;
use Xtuple\Util\HTTP\Request\URI\URL\URLString;
use Xtuple\Util\JWT\Claim\Claim\Registered\Issuer\Issuer;

final class ConnectionStruct
  implements Connection {
  /** @var string */
  private $application;
  /** @var string */
  private $host;
  /** @var string */
  private $database;
  /** @var Issuer */
  private $iss;
  /** @var string */
  private $key;
  /** @var bool */
  private $debug;

  public function  __construct(string $application, string $host, string $database, Issuer $iss, string $key,
                              bool $debug = false) {
    $this->application = $application;
    $this->host = $host;
    $this->database = $database;
    $this->iss = $iss;
    $this->key = $key;
    $this->debug = $debug;
  }

  public function serialize() {
    return serialize([
      'application' => $this->application,
      'host' => $this->host,
      'database' => $this->database,
      'iss' => $this->iss,
      'key' => $this->key,
      'debug' => $this->debug,
    ]);
  }

  public function unserialize($serialized) {
    $data = unserialize($serialized, ['allowed_classes' => true]);
    $this->__construct(
      $data['application'],
      $data['host'],
      $data['database'],
      $data['iss'],
      $data['key'],
      $data['debug']
    );
  }

  public function url(): string {
    return strtr('{host}/{db}', [
      '{host}' => $this->host(),
      '{db}' => $this->database,
    ]);
  }

  public function discovery(): string {
    return "{$this->url()}/discovery/v1alpha1/apis/v1alpha1/rest";
  }

  public function token(): URL {
    /** @noinspection PhpUnhandledExceptionInspection */
    return new URLString("{$this->url()}/oauth/v2/token");
  }

  public function application(): string {
    return $this->application;
  }

  public function host(): string {
    return rtrim($this->host, '/');
  }

  public function database(): string {
    return $this->database;
  }

  public function iss(): Issuer {
    return $this->iss;
  }

  public function key(): string {
    return $this->key;
  }

  public function debug(): bool {
    return $this->debug;
  }
}
