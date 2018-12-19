<?php declare(strict_types=1);

namespace Xtuple\Client\OAuth2\Client\Token\Scope;

use PHPUnit\Framework\TestCase;

class ScopeStructTest
  extends TestCase {
  /**
   * @throws \Throwable
   */
  public function testConstructor() {
    $scope = new ScopeStruct('05098435b82fa53ab8dc5a713ca1f43a93c7685c');
    self::assertEquals(
      'externalId:05098435b82fa53ab8dc5a713ca1f43a93c7685c customer:GUEST',
      $scope->value()
    );
    self::assertEquals('', $scope->site());
    $scope = new ScopeStruct(
      '05098435b82fa53ab8dc5a713ca1f43a93c7685c',
      'CUSTOMER@XTUPLE.COM',
      '2f8176d1-3264-404e-828d-0a5ba5dd02b5',
      'WAREHOUSE',
      'ADMIN'
    );
    self::assertEquals(
      implode(' ', [
        'externalId:05098435b82fa53ab8dc5a713ca1f43a93c7685c',
        'customer:CUSTOMER@XTUPLE.COM',
        'shipTo:2f8176d1-3264-404e-828d-0a5ba5dd02b5',
        'site:WAREHOUSE',
        'employee:ADMIN',
      ]),
      $scope->value()
    );
    self::assertEquals('WAREHOUSE', $scope->site());
  }
}
