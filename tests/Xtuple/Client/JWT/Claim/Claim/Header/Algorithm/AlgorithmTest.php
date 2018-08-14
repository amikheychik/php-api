<?php declare(strict_types=1);

namespace Xtuple\Client\JWT\Claim\Claim\Header\Algorithm;

use Xtuple\Client\JWT\Claim\Claim\Header\Algorithm\Test\AlgorithmTestCase;
use Xtuple\Util\JWT\Test\RSA256FromJWTIO;
use Xtuple\Util\Type\String\Encoding\Base64\Encode\URLSafe\URLSafeBase64EncodedStringFromString;

class AlgorithmTest
  extends AlgorithmTestCase {
  /**
   * @throws \Throwable
   */
  public function testConstructor() {
    $algorithm = new Algorithm($this->p12);
    $header = new URLSafeBase64EncodedStringFromString('{"alg":"RS256","typ":"JWT"}');
    $content = new URLSafeBase64EncodedStringFromString(
      '{"sub":"1234567890","name":"John Doe","admin":true,"iat":1516239022}'
    );
    $jwtIO = new RSA256FromJWTIO();
    self::assertEquals(1, openssl_verify(
      "{$header}.{$content}",
      $algorithm->sign("{$header}.{$content}"),
      $jwtIO->public(),
      OPENSSL_ALGO_SHA256
    ));
    /** @noinspection SpellCheckingInspection */
    self::assertEquals(
      implode('', [
        'TCYt5XsITJX1CxPCT8yAV-TVkIEq_PbChOMqsLfRoPsnsgw5WEuts01mq-pQy7UJiN5mgRxD-WUcX',
        '16dUEMGlv50aqzpqh4Qktb3rk-BuQy72IFLOqV0G_zS245-kronKb78cPN25DGlcTwLtjPAYuNzVB',
        'Ah4vGHSrQyHUdBBPM',
      ]),
      new URLSafeBase64EncodedStringFromString(
        $algorithm->sign("{$header}.{$content}")
      )
    );
  }
}
