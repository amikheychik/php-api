<?php declare(strict_types=1);

namespace Xtuple\Client\JWT\Claim\Claim\Header\Algorithm\OpenSSL\Keypair;

use PHPUnit\Framework\TestCase;

class PKCS12KeypairTest
  extends TestCase {
  /** @var string */
  protected $directory = '/tmp/phpunit/php-api/pkcs12';
  /** @var resource - OpenSSL private key */
  protected $private;
  /** @var string - P12 password */
  protected $password = 'notasecret';

  /**
   * @throws \Throwable
   */
  protected function setUp() {
    parent::setUp();
    if (!file_exists($this->directory)) {
      mkdir($this->directory, 0777, true);
    }
    $this->private = openssl_pkey_new([
      'private_key_bits' => 2048,
      'private_key_type' => OPENSSL_KEYTYPE_RSA,
    ]);
    openssl_pkey_export_to_file($this->private, "{$this->directory}/private.pem");
    $csr = openssl_csr_new([
      'commonName' => 'localhost',
      'countryName' => 'US',
      'stateOrProvinceName' => 'Virginia',
      'localityName' => 'Norfolk',
      'organizationName' => 'xTuple',
      'organizationalUnitName' => 'Development',
    ], $this->private);
    openssl_csr_export_to_file($csr, "{$this->directory}/localhost.csr");
    $crt = openssl_csr_sign($csr, null, $this->private, 365);
    openssl_x509_export_to_file($crt, "{$this->directory}/localhost.crt");
    openssl_pkcs12_export_to_file($crt, "{$this->directory}/localhost.p12", $this->private, $this->password);
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

  /**
   * @throws \Throwable
   */
  public function testConstructor() {
    $pkcs12 = new PKCS12Keypair("{$this->directory}/localhost.p12");
    /** @var PKCS12Keypair $pkcs12 */
    $pkcs12 = unserialize(serialize($pkcs12));
    $private = openssl_pkey_get_private($pkcs12->private());
    openssl_pkey_export($private, $actual);
    openssl_pkey_export($this->private, $expected);
    self::assertEquals($expected, $actual);
  }
}
