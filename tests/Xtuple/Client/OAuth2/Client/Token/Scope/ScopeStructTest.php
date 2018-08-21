<?php declare(strict_types=1);

namespace Xtuple\Client\OAuth2\Client\Token\Scope;

use PHPUnit\Framework\TestCase;

class ScopeStructTest
  extends TestCase {
  /**
   * @throws \Throwable
   */
  public function testConstructor() {
    $scope = new ScopeStruct('erp', '05098435b82fa53ab8dc5a713ca1f43a93c7685c');
    self::assertEquals(
      'erp.session.externalId:05098435b82fa53ab8dc5a713ca1f43a93c7685c erp.session.customer:GUEST',
      $scope->value()
    );
    self::assertEquals('', $scope->site());
    $scope = new ScopeStruct(
      'erp',
      '05098435b82fa53ab8dc5a713ca1f43a93c7685c',
      'CUSTOMER@XTUPLE.COM',
      '2f8176d1-3264-404e-828d-0a5ba5dd02b5',
      'WAREHOUSE'
    );
    self::assertEquals(
      implode(' ', [
        'erp.session.externalId:05098435b82fa53ab8dc5a713ca1f43a93c7685c',
        'erp.session.customer:CUSTOMER@XTUPLE.COM',
        'erp.session.shipTo:2f8176d1-3264-404e-828d-0a5ba5dd02b5',
        'erp.session.site:WAREHOUSE',
      ]),
      $scope->value()
    );
    self::assertEquals('WAREHOUSE', $scope->site());
  }
}
