<?php declare(strict_types=1);

namespace Xtuple\Client\JWT\Claim\Claim\Header\Algorithm\OpenSSL\Keypair;

use Xtuple\Util\Exception\Throwable;
use Xtuple\Util\File\File\FileFromPathString;
use Xtuple\Util\JWT\Claim\Claim\Header\Algorithm\OpenSSL\Keypair\AbstractKeypair;
use Xtuple\Util\JWT\Claim\Claim\Header\Algorithm\OpenSSL\Keypair\PKCS12\PKCS12File;

/**
 * Keypair password is hardcoded in the API.
 */
final class PKCS12Keypair
  extends AbstractKeypair {
  /**
   * @throws Throwable
   *
   * @param string $keypath
   */
  public function __construct(string $keypath) {
    parent::__construct(new PKCS12File(
      new FileFromPathString($keypath),
      'notasecret'
    ));
  }
}
