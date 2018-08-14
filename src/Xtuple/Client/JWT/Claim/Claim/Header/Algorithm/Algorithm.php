<?php declare(strict_types=1);

namespace Xtuple\Client\JWT\Claim\Claim\Header\Algorithm;

use Xtuple\Client\JWT\Claim\Claim\Header\Algorithm\OpenSSL\Keypair\PKCS12Keypair;
use Xtuple\Util\Exception\Throwable;
use Xtuple\Util\JWT\Claim\Claim\Header\Algorithm\AbstractAlgorithm;
use Xtuple\Util\JWT\Claim\Claim\Header\Algorithm\OpenSSL\RS256OpenSSL;

final class Algorithm
  extends AbstractAlgorithm {
  /** @var RS256OpenSSL */
  private $algorithm;

  /**
   * @throws Throwable
   *
   * @param string $keypath
   */
  public function __construct(string $keypath) {
    $this->algorithm = new RS256OpenSSL(
      new PKCS12Keypair($keypath)
    );
    parent::__construct($this->algorithm->value());
  }

  public function sign(string $content): string {
    return $this->algorithm->sign($content);
  }
}
