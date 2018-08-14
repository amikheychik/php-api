<?php declare(strict_types=1);

namespace Xtuple\Client\JWT\Claim\Claim\Header\Algorithm\Test;

use PHPUnit\Framework\TestCase;
use Xtuple\Util\JWT\Test\RSA256FromJWTIO;

abstract class AlgorithmTestCase
  extends TestCase {
  /** @var string */
  protected $directory;
  /** @var string */
  protected $p12 = '/tmp/phpunit/php-api/pkcs12/jwt-io.p12';
  /** @var resource - OpenSSL private key */
  protected $private;
  /** @var string - P12 password */
  protected $password = 'notasecret';

  /**
   * @throws \Throwable
   */
  protected function setUp() {
    parent::setUp();
    $this->directory = dirname($this->p12);
    if (!file_exists($this->directory)) {
      mkdir($this->directory, 0777, true);
    }
    $jwtIO = new RSA256FromJWTIO();
    $private = openssl_pkey_get_private($jwtIO->private());
    $csr = openssl_csr_new([
      'commonName' => 'localhost',
    ], $private);
    $crt = openssl_csr_sign($csr, null, $private, 1);
    openssl_pkcs12_export_to_file($crt, $this->p12, $private, $this->password);
  }

  protected function tearDown() {
    parent::tearDown();
    $directory = new \DirectoryIterator($this->directory);
    foreach ($directory as $file) {
      if (!$file->isDot()) {
        unlink($file->getRealPath());
      }
    }
    rmdir($this->directory);
  }
}
